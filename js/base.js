"use strict"
//routing and navigation

var app = angular.module('givingHands', ['ngRoute', 'ngResource']);//init js
app.config(function($routeProvider){
    $routeProvider.when('/', {
        templateUrl: 'splash.html',
        controller: 'splash'
    }).when('/start', {
        templateUrl: 'start-donation.html',
        controller: 'landing-page'
    }).when('/home', {
        templateUrl: 'home.html',
        controller: 'home'
    }).when('/user-details', {
        templateUrl: 'user-details.html',
        controller: 'userDetails'
    }).when('/process-donation', {
       templateUrl: 'donate.html',
       controller: 'donate' 
    }).when('/profile', {
        templateUrl: 'profile.html',
        controller: 'profile'
    }).when('/store', {
        templateUrl: 'auction.html',
        controller: 'auction'
    }).otherwise({
        redirectTo: '/'
    })
});

app.controller('splash', function($scope, $rootScope){
	document.addEventListener('deviceready', function(){
		let isUser = window.localStorage.getItem('isUser');
		console.log(isUser);
		if(isUser){
			window.location = '#/home';
		}
		else{
			window.localStorage.setItem('isUser', 'true');
			window.location = '#/start';
		}
	}, false);
})
app.controller('landing-page', function($scope){
    Jolly.debounceScroll();
    $scope.goHome = function(){
        /*
            Triggered when user taps Get Started on Home page
        */
        window.location = '#/home'
    }
});

app.controller('home', function ($scope, $rootScope) {
    $('.navigator').show();
    $scope.registerItem = function(){
        /**
          a user already registered or logged in does not need to enter details
           */
        if($scope.itemName && $scope.itemCategory){
            FileBase.getProfile(function(profile){
                if(profile){
                    //logged in donate straightaway
                    $rootScope.requestDetails = {
                        service: 'donation',
                        itemName: $scope.itemName,
                        itemCategory: $scope.itemCategory
                    }
                    window.location = '#/process-donation'
                }
                else{
                    //not logged in direct to login
                    $rootScope.requestDetails = {
                        service: 'donation',
                        itemName: $scope.itemName,
                        itemCategory: $scope.itemCategory
                    }
                    window.location = '#/user-details';
                    $('.navigator').hide();
                }
            }, function(err){
                alert('Fatal Error')
            })  
        }
        else{
            window.plugins.toast.showLongBottom('Some fields are not filled')
        }
    }
});

app.controller('userDetails', function($scope, $rootScope){
    if(!$rootScope.requestDetails){
        //invalid login debounce
        history.back();
    }
    $('.navigator').hide();
    $scope.registerPrompt = 'Register';
    $scope.busy = false;
    $scope.loginPrompt = 'Login';
    $scope.register = function(){
        $scope.busy = true;
        $scope.registerPrompt = 'Wait a bit..'
        if($scope.fName && $scope.lName && $scope.email && $scope.pNumber && $scope.pWord){
            //check value validity and send request
            if($rootScope.requestDetails.service){
                let data = {
                    fName: $scope.fName,
                    lName: $scope.lName,
                    email: $scope.email,
                    pNumber: $scope.pNumber,
                    pword: $scope.pWord,
                    district: $scope.district
                }
                Jolly.requestBackend('register/', 'POST', data, function(res){
                    if(res.success){
                        //user registered write to profile and redirect
                        FileBase.writeProfile(data, function(){
                            if($rootScope.requestDetails.service == 'donation'){
                                window.location = '#/process-donation'
                            }
                            else if($rootScope.requestDetails.service == 'profile'){
                                window.location = '#/profile'
                            }
                        }, function(){
                            alert('ERR')
                        })
                    }
                    else{
                        $scope.$apply(function(){
                            $scope.registerPrompt = 'Register'
                        })
                        alert('Donor registration failed try again')
                    }             
                }, function(err){
                    $scope.$apply(function(){
                        $scope.registerPrompt = 'Register'
                    })
                    window.plugins.toast.showShortBottom(err)
                })
            }
            //else service is purchase or other 
        }
        else{
            window.plugins.toast.showLongBottom('Some fields are not filled')
        }
    }
    $scope.login = function(){
        if($scope.email && $scope.pWord){
            //valid
            $scope.loginPrompt = 'Wait a bit..'
            let data = {
                email: $scope.email,
                pWord: $scope.pWord
            }
            if($rootScope.requestDetails.service){
                Jolly.requestBackend('login/', 'POST', data, function(res){
                    if(res.success){
                        FileBase.writeProfile(res.data, function(){
                            if($rootScope.requestDetails.service == 'donation'){
                                window.location = '#/process-donation'
                            }
                            else if($rootScope.requestDetails.service == 'profile'){
                                window.location = '#/profile'
                            }                        
                        }, function(){
                            alert('ERR')
                        })
                    }
                    else{
                        $scope.$apply(function(){
                            $scope.loginPrompt = 'Login'
                        })
                        alert('Login error: details incorect')
                    }
                    //window.location = '#/process-donation'
                }, function(err){
                    $scope.$apply(function(){
                        $scope.loginPrompt = 'Login'
                    })
                    window.plugins.toast.showLongBottom(err)
                })
            }
        }
        else{
            window.plugins.toast.showLongBottom('Some fields are not filled')
        }
    }
})

app.controller('donate', function($scope, $rootScope){
    $scope.isBusy = true;
	$('.navigator').hide();
    if(!$rootScope.requestDetails){
        history.back();
    }
    FileBase.getProfile(function(profile){
        if(profile){
            //logged in
            let user = JSON.parse(profile)
            let details = $rootScope.requestDetails;
            details.userId = user.ID;
            Jolly.requestBackend('donate/', 'POST', details, function(res){
                //$scope.isBusy = false;
                if(res.success){
                    $scope.$apply(function(){
                        $scope.isBusy = false;
                        $scope.donorName = user.fName;
                        $scope.donorPhone = user.phoneNumber;
                        $scope.donorEmail = user.email;
                        $scope.item = details.itemName;
                    })
                }
                else{
                    window.plugins.toast.showLongBottom('Error registering donation')
                    history.back()
                }
                
            }, function(err){
                window.plugins.toast.showLongBottom('Network/Server error')
            })
        }
        else{
            window.plugins.toast.showLongBottom('login/Register first')
            window.location = '#/user-details'
        }
    }, function(){
        alert('Fatal Error')
    })
})

app.controller('profile', function($scope, $rootScope){
    $('.navigator').show();
    Jolly.initJquery();
    FileBase.getProfile(function(profile){
        if(profile){
            //logged in
            let p = JSON.parse(profile);
            $scope.$apply(function(){
                $scope.fName = p.fName;
                $scope.lName = p.lName;
                $scope.email = p.email;
                $scope.phoneNumber = p.phoneNumber;
                $scope.district = null;
            })
        }
        else{
            $rootScope.requestDetails = {
                service: 'profile'
            }
            window.location = '#/user-details'
        }
    }, function(){
        history.back()
    })
})

app.controller('auction', function($scope){
    $scope.isBusy = true;
    $scope.storePrompt = 'Loading..';
    Jolly.requestBackend('auction/get-items/', 'GET', null, function(items){
        $scope.$apply(function(){
            $scope.isBusy = false;
            $scope.items = items;
        })
    }, function(err){
        $scope.$apply(function(){
            $scope.storePrompt = 'Network/Server error'
        })
    })
    $(window).scroll(function(evt){
    })
})