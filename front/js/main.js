//vanilla js and angular js

"use strict"

const domain = "http://localhost:8080/story/";
var app = angular.module('story', ['ngRoute', 'ngResource']);
//router
app.config(function($routeProvider){
	$routeProvider.when('/', {
		templateUrl: 'splash1.html',
		controller: 'loader'
	}).when('/sp', {
		templateUrl: 'splash.html',
		controller: 'splash'
	}).when('/home', {
		templateUrl: 'home.html',
		controller: 'home'
	}).when('/choose_mode', {
		templateUrl: 'choose_mode.html',
		controller: 'selectMode'
	}).when('/reader', {
		templateUrl: 'reader.html',
		controller: 'reader'
	}).when('/tts', {
		templateUrl: 'tts.html',
		controller: 'tts'
	}).when('/search', {
		templateUrl: 'search.html',
		controller: 'search'
	}).when('/t', {
		templateUrl: 'test.html',
		controller: 'test'
	}).when('/downloads', {
		templateUrl: 'downloads.html',
		controller: 'downloads'
	}).when('/contribute', {
		templateUrl: 'contribute.html',
		controller: 'contribute'
	}).when('/query',{
		templateUrl: 'query.html',
		controller: 'query'
	}).when('/quiz', {
		templateUrl: 'quiz.html',
		controller: 'quiz'
	}).when('/score', {
		templateUrl: 'score.html',
		controller: 'score'
	}).otherwise({
		redirectTo:'/'
	})
});

//controllers

app.controller('loader', function($scope, $rootScope){
	document.addEventListener('deviceready', function(){
		if($rootScope.cVisit){
			//exit app
			if(navigator.device){
				navigator.device.exitApp();
			}
			else if(navigator.app){
				navigator.app.exitApp();
			}
			//
			else{
				alert('cant exit')
			}
		}
		else{
			$rootScope.cVisit = true;
			$rootScope.mustLoad = true;
			window.location = '#/sp'
		}
	}, false);
})

app.controller('splash', function($scope, $rootScope, $http){
	$rootScope.onload = true;
	if(!$rootScope.mustLoad){
		window.location = '#/';
		//exit
	}
	else{
		//to prevent parts of audio playing on exit
		var m;
		animate();
		var src=cordova.file.applicationDirectory+'www/music-box-toy-melody-looping_G1jdmH4O_WM.mp3';
		m = new Media(src, function(){}, function(e){alert('We have experinced an error plying audio. Check phone sttings')});
		m.play();
		const options = {
			method: 'get'
			};
		var userId = window.localStorage.getItem('userId');
		if(!userId){
			let alphabet = 'abcdefghijklmnopqrstuvwxyz';
			let h = '';
			for(var i = 0; i<6; i++){
				let i = Math.round(Math.random()*26);
				h = h+alphabet[i];
			}
			userId = h;
			window.localStorage.setItem('userId', userId);
		}
		window.setTimeout(function(){
			//delay for five seconds
			cordova.plugin.http.sendRequest(domain+"/api/init/?user="+userId, options, function(response){
				$rootScope.initData = JSON.parse(response.data);
				$rootScope.mustLoad = false;
				let notes = $rootScope.initData[2].Notifications;
				if(notes){
					//has notifications
					let notesFinal = [];
					for(let i = 0; i<notes.length; i++){
						let obj = {};
						obj.id = i;
						obj.title = notes[i].title;
						obj.text = notes[i].body;
						notesFinal.push(obj);
					}
					cordova.plugins.notification.local.schedule(notesFinal);
				}
				m.stop();
				window.location = '#/home'
			}, function(error){
				$rootScope.mustLoad = false;
				window.plugins.toast.showLongBottom('Connecting to API Server failed...app has loaded in download mode');
				m.stop();
				window.location = '#/downloads';
			});
		}, 5000);	
	}
});

app.controller('home', function($scope, $rootScope){
	initJquery();
	$scope.inOperation = false;
	if($rootScope.initData){
		$scope.categories = $rootScope.initData[0].Categories;
		$scope.stories=$rootScope.initData[1].Stories;
		if($rootScope.onload){
			//to prevent playing welcome message when home is reloaded by user
			let descAudioSrc = cordova.file.applicationDirectory+'www/862ce178-b20d-4745-b82d-57cc15c883d8.mp3';
			let descAudio = new Media(descAudioSrc, function(){}, function(e){console.log(e)});
			descAudio.play();
			$rootScope.onload = false;
		}
	}
	else{
		//reset
		window.location = '#/';
	}
	$scope.openReader = function(index){
		$rootScope.selectedStory = index;
		window.location='#/choose_mode';
	}
	$scope.changeCategory = function(category){
		let categoryId = category.ID;
		window.plugins.toast.showLongTop('Loading..')
		const options = {
			method: 'get'
		};
		cordova.plugin.http.sendRequest(domain+'api/category/?id='+categoryId, options, function(response){
			let res = JSON.parse(response.data);
			if(res[0].length>0){
				$scope.$apply(function(){
					$scope.stories = res[0];
				});
			}
			else{
				$scope.stories = res[0];
				window.plugins.toast.showLongBottom('No stories in category');
			}
		}, function(error){
			$scope.stories = res[0];
			window.plugins.toast.showLongBottom("no connection to API");
		});
	}
	$scope.switchToDownloads = function(){
		window.location = '#/downloads';
	}
});

app.controller('selectMode', function($scope, $rootScope){
	$scope.loading = false;
	$scope.tts = true;
	if($rootScope.selectedStory){
		$scope.story = $rootScope.selectedStory;
		console.log($scope.story);
	}
	else{
		//reset
		window.location = '#/';
	}
	$scope.getStory = function(){
		FileBase.writeToStoriesFile($scope.story, function(res){
			$scope.$apply(function(){
				if(!res){
					$('#downloadRate').show();
					//load the story then download media and save
					let options = {
						method: 'get'
					}
					cordova.plugin.http.sendRequest(domain+'api/story/read/?id='+$scope.story.ID, options, function(fullStory){
						let fStory = fullStory.data;
						FileBase.saveStory($scope.story, fStory, $scope, function(status, errorCode){
							if(status){
								//proceed to download media files
									$scope.$apply(function(){
										$scope.downloadRate = '0%';
										FileBase.downloadStoryMedia($scope.story, fStory, $scope, function(){
											$rootScope.fullStory = fStory;
											window.location = '#/reader';
										});
									});
							}
							else{
								window.plugins.toast.showLongBottom('Error: '+e.toString());
							}
						});
					}, function(err){
						console.log(err);
						$scope.$apply(function(){
							$scope.downloadRate = 'Failed';
						});
						window.plugins.toast.showLongBottom('Download cancelled due to HTTP connection error home');
						$rootScope.onload = false;
						window.location = '#/';
					});
				}
				else{
					//try reading
					$('#downloadRate').hide();
					FileBase.extractFullStory($scope.story, function(fullStory){
						$rootScope.fullStory = JSON.parse(fullStory);
						window.location = '#/reader';
					});
				}
			});
		});
	}
	
	$scope.narrateStory = function(){
		if($scope.story.hasAudio === '1'){
			FileBase.writeToStoriesFile($scope.story, function(res){
			$scope.$apply(function(){
				if(!res){
					$('#downloadRate').show();
					//load the story then download media and save
					let options = {
						method: 'get'
					}
					cordova.plugin.http.sendRequest(domain+'api/story/read/?id='+$scope.story.ID, options, function(fullStory){
						let fStory = fullStory.data;
						console.log(fullStory);
						FileBase.saveStory($scope.story, fStory, $scope, function(status, errorCode){
							console.log(status);
							if(status){
								//proceed to download media files
									$scope.$apply(function(){
										$scope.downloadRate = '0%';
										FileBase.downloadStoryMedia($scope.story, fStory, $scope, function(){
											$rootScope.fullStory = fStory;
											window.location = '#/tts';
										});
									});
							}
							else{
								alert('Error: '+e.toString());
							}
						});
					}, function(err){
						console.log(err);
						$scope.$apply(function(){
							$scope.downloadRate = 'Failed';
						});
						window.plugins.toast.showLongBottom('Download cancelled due to HTTP connection error home');
						$rootScope.onload = false;
						window.location = '#/';
					});
				}
				else{
					//try reading
					$('#downloadRate').hide();
					FileBase.extractFullStory($scope.story, function(fullStory){
						$rootScope.fullStory = JSON.parse(fullStory);
						window.location = '#/tts';
					});
				}
			});
		});
		}
		else{
			alert('This story does not support narration');
		}
	}
});

app.controller('reader', function($scope, $rootScope, $http){
	if(typeof $rootScope.fullStory === 'string') $rootScope.fullStory = JSON.parse($rootScope.fullStory);
	else $rootScope.fullStory = $rootScope.fullStory; //after first read story is already parsed
	$scope.quiz = $rootScope.fullStory[1];
	if($rootScope.fullStory){
		$scope.fullStory = $rootScope.fullStory[0];//first slide put in local scope
		$scope.slide = $scope.fullStory[0];
		$scope.currSlide = 0;
		$scope.hasQuiz = false;
		if($rootScope.selectedStory.hasQuiz === '1'){
			$scope.hasQuiz = true;
		}
		$scope.maxSlide = $scope.fullStory.length-1;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);	
	}	
	else{
		window.location = '#/';
	}
	$scope.next = function(){
		$scope.slide = $scope.fullStory[$scope.currSlide+1];
		$scope.currSlide++;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);	
	}
	$scope.previous = function(){
		$scope.slide = $scope.fullStory[$scope.currSlide-1];
		$scope.currSlide--;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);	
	}
	$scope.takeQuiz = function(){
		window.location = '#/quiz';
	}
	$scope.back = function(){
		if($rootScope.initData){
			//online
			window.location = '#/home';
		}
		else{
			window.location = '#/downloads';
		}
	}
	$('.reader-area').click(function(){
		$('.home-ic').fadeIn('fast')
	})
	setInterval(function(){
		//hide home button every 2secs
		if(!$('.home-ic').is(':hidden')){
			$('.home-ic').fadeOut('slow')
		}
	}, 4000);
});

app.controller('tts', function($scope, $rootScope){
	let captionAudio;
	if(typeof $rootScope.fullStory === 'string') $rootScope.fullStory = JSON.parse($rootScope.fullStory);
	else $rootScope.fullStory = $rootScope.fullStory; //after first read story is already parsed
	$scope.quiz = $rootScope.fullStory[1];
	if($rootScope.fullStory){
		$scope.fullStory = $rootScope.fullStory[0];//story put in local scope
		$scope.slide = $scope.fullStory[0];
		$scope.currSlide = 0;
		$scope.hasQuiz = false;
		if($rootScope.selectedStory.hasQuiz === '1'){
			$scope.hasQuiz = true;
		}
		$scope.maxSlide = $scope.fullStory.length-1;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);
		let audioSrc = 'cdvfile://localhost/files/'+$scope.slide.slide_audio;
		captionAudio = new Media(audioSrc, function(){}, function(e){console.log(e)});
		captionAudio.play();
	}	
	else{
		window.location = '#/';
	}
	$scope.next = function(){
		captionAudio.stop();
		$scope.slide = $scope.fullStory[$scope.currSlide+1];
		$scope.currSlide++;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);	
		let audioSrc = 'cdvfile://localhost/files/'+$scope.slide.slide_audio;
		captionAudio = new Media(audioSrc, function(){}, function(e){console.log(e)});
		captionAudio.play();
	}
	$scope.previous = function(){
		captionAudio.stop();
		$scope.slide = $scope.fullStory[$scope.currSlide-1];
		$scope.currSlide--;
		let imgSrc = $scope.slide.slide_image;
		$('#slideImg').attr('src', 'cdvfile://localhost/files/'+imgSrc);	
		let audioSrc = 'cdvfile://localhost/files/'+$scope.slide.slide_audio;
		captionAudio = new Media(audioSrc, function(){}, function(e){console.log(e)});
		captionAudio.play();
	}
	$scope.takeQuiz = function(){
		window.location = '#/quiz';
	}
	$scope.back = function(){
		if($rootScope.initData){
			//online
			window.location = '#/home';
		}
		else{
			window.location = '#/downloads';
		}
	}
	$('.reader-area').click(function(){
		$('.home-ic').fadeIn('fast')
	})
	setInterval(function(){
		//hide home button every 2secs
		if(!$('.home-ic').is(':hidden')){
			$('.home-ic').fadeOut('slow')
		}
	}, 4000)
	$scope.$on('destroy', function(){
		console.log('destroy');
		captionAudio.stop();
	});
});

app.controller('search', function ($scope, $rootScope) {
	$scope.search = function () {
		window.plugins.toast.showLongBottom('Searching')
		let searchTerm = $scope.searchTerm;
		const options = {
			method: 'get'
		};
		cordova.plugin.http.sendRequest(domain+'api/search/?q='+searchTerm, options, function(result){
			$scope.searchResult=JSON.parse(result.data)[0];
			if($scope.searchResult.length === 0) 	window.plugins.toast.showLongBottom('No results for search')
		}, function(error){
			window.plugins.toast.showLongBottom('HTTP connection error')
		});
	}
	$scope.openStory = function (story) {
		$rootScope.selectedStory = story;
		window.location='#/choose_mode';
	}
	$scope.s = function(evt){
		if(evt.keyCode === 13){
			$scope.search();
		}
	}
});

app.controller('downloads', function($scope, $rootScope){
	$scope.stories = [];
	FileBase.getDownloadList(function(res){
		if(res){
			$scope.$apply(function(){
				console.log(res);
				$scope.stories = JSON.parse(res);
			});
		}
		else{
			window.plugins.toast.showLongBottom('No downloads available');
		}
	});
	$scope.openReader = function(index){
		$rootScope.selectedStory = index;
		window.location='#/choose_mode';
	}
	$scope.switchOnline = function(){
		$rootScope.mustLoad = true;
		window.location = '#/sp';
	}
	$scope.dropStory = function(index){
		if(confirm(`Are you sure you want to delete '${index.title}'`)){
			FileBase.dropStory(index, function(nList){
				window.plugins.toast.showLongBottom('Story deleted successfully');
				$scope.$apply(function(){
					$scope.stories = nList;
				});
			}, function(e){
				alert(e.toString());
			})
		}
	}
});

app.controller('query', function($scope, $rootScope){
	$scope.sendQuery = function(){
		let query = $scope.query;
		let options = {
			method: 'get'
		};
		let userId = window.localStorage.getItem('userId');
		cordova.plugin.http.sendRequest(domain+'api/query/?uid='+userId+'&q='+query, options, function(res){
			let response = JSON.parse(res.data);
			if(response.success){
				alert('Query sent our team will get back to you soon');
			}
			else{
				window.plugins.toast.showLongBottom('Action not permitted');
			}
		}, function(err){
			console.log(err);
			window.plugins.toast.showLongBottom('HTTP ERROR');
		});
	}
});

app.controller('contribute', function($scope){
	$scope.sendSubmission = function(){
		let submissionTitle = $scope.title;
		let userName = $scope.name;

		let options = {
			method: 'get'
		}
		cordova.plugin.http.sendRequest(`${domain}/api/user_submission/register/?uid=${userName}&subTitle=${submissionTitle}`, options, function(res) {
			let response = JSON.parse(res.data);
			
			if(response.success){
				window.plugins.toast.showLongBottom('Your proposal was submitted, thank you.')
			}
			else{
				window.plugins.toast.showLongBottom('ERROR');
			}
		}, function (error) {
			window.plugins.toast.showLongBottom('HTTP ERROR');
		})
	}
});

app.controller('quiz', function($scope, $rootScope){
	let quiz = $rootScope.fullStory[1];
	$scope.numOfQuestions = quiz.length;	
	if(quiz.length === 0)
	$scope.qIndex = 1;
	$scope.maxQuestion = quiz.length-1;
	$scope.answer = null;
	$scope.ans = '';
	$scope.score = 0;
	//first question
	$scope.currQuestion = quiz[0];
	$scope.qIndex = 0;
	$scope.qNumber = 1;
	$scope.questionTitle = $scope.currQuestion.question.question_title;
	$scope.answerOptions = $scope.currQuestion.options;
	$('.radio').click(function(evt){
		console.log(evt)
	})
	$scope.submitAnswer = function(ans){
		$scope.answer = ans.isAnswer;
	}
	$scope.nextQuestion = function(){
		if($scope.answer){
			if($scope.answer === 'true'){
				$scope.score++;
			}
			$scope.answer = null;//previous answer removed;
			$scope.qIndex++;
			$scope.qNumber++;
			$scope.currQuestion=quiz[$scope.qIndex];
			$scope.questionTitle = $scope.currQuestion.question.question_title;
			$scope.answerOptions = $scope.currQuestion.options;
		}
		else{
			window.plugins.toast.showLongBottom('Select an answer first');
		}
		
	}
	$scope.getScore = function(){
		if($scope.answer){
			let levelCompleted = cordova.file.applicationDirectory+'www/level-completed/level-completed.mp3';
			let levAudio = new Media(levelCompleted, function(){}, function(e){console.log(e)});
			levAudio.play();
			if($scope.answer === 'true'){
				$scope.score++;
			}
			$rootScope.finalScore = (($scope.score*100)/quiz.length);
			window.location ='#/score';
		}
		else{
			window.plugins.toast.showLongBottom('Select an answer first');
		}
	}	
	$scope.exitQuiz = function(){
		window.location = '#/choose_mode';
	}
});

app.controller('score', function($scope, $rootScope){
	if($rootScope.finalScore >= 50){
		animateConfetti();
		let applause = cordova.file.applicationDirectory+'www/level-completed/applause-01.wav';
		let appAudio = new Media(applause, function(){}, function(e){console.log(e)});
		appAudio.play();
	}
	$scope.story = $rootScope.selectedStory;
	$scope.score = Math.floor($rootScope.finalScore);
	$scope.msg = '';
	if($scope.score >= 70) $scope.msg ='Excellent';
	else if($scope.score >= 50) $scope.msg = 'Good';
	else $scope.msg = 'Sorry Try Again';
	$scope.back = function(){
		if($rootScope.initData){
			//online
			window.location = '#/home';
		}
		else{
			window.location = '#/downloads';
		}
	}
});

let makeCatBold = function(evt){
	let el = evt;
	var h3;
	if(evt.target.tagName === 'H3'){
		h3 = evt.target;//target was test so simply assign
	}
	else{
		h3 = el.target.parentNode.childNodes[3].lastChild; //target was another element ie image in div so locate h3 in DOM
	}
	$(h3).css('font-weight', 'bold');
	$('.category-mark').css('font-weight', 'normal');
	$('.category-mark').css('color', 'white');
	$(h3).css('font-weight', 'extra-bold');
	$(h3).css('font-weight', 'bold');
	$(h3).css('color', 'red');
}
