//Papa Jimayooo
"use strict"
let FileBase = {};
let Jolly = {};
let changeContainer = function(elNum){
    let width = screen.width;
    let scrollLevel = (elNum/100)*width;
    $('.slider-wrapper').scrollLeft(scrollLevel);
}
let activateAnchor = function (evt) {
    $('.nav-btn').css('color', '#8d8d8d');
    let el;
    if(evt.target.tagName === 'A'){
        //parent simply change color
        el = evt.target;
    }
    else{
        el = evt.target.parentElement
    }
    $(el).css('color', '#742adb');
}
let displayLogin = function () {
    $('.register').hide();
    $('.login').show();
}

FileBase.getProfile = function(onsuccess, error){
    if(storiesFile){
        let fReader = new FileReader();
        storiesFile.file(function(file){
            fReader.onloadend = function(){
				onsuccess(this.result);
            }
            fReader.onerror = function(e){
                error(e.toString());
            }
            fReader.readAsText(file);
        });
    }
    else{
        onsuccess(false);//no profile available
    }
}

FileBase.writeProfile = function(data, onsuccess, onerror){
    let dataStr = JSON.stringify(data)
    storiesFile.createWriter(function(writer){
        writer.write(dataStr);
        writer.onwriteend = function(){
            onsuccess();
        }
        writer.onwriteerror = function(){
            onerror();
        }
    })
}

Jolly.debounceScroll = function(){
    const children = $('#container')[0].children;
    const debounceAfter = 200;
    let to = 0;
    let currentScrollWidth = 0;

    $('#container').scroll(function(){
            setTimeout(function(){
                currentScrollWidth = $('#container')[0].scrollLeft;
                let index = Math.round(currentScrollWidth/children[0].offsetWidth);
                to = children[index].offsetLeft;
                $('#container')[0].scrollLeft = to;
                console.log(to);
            }, debounceAfter) 
        }
    )
}

Jolly.requestBackend = function(url, method, data, success, onerror){
    const backend = 'http://geniotestmw.000webhostapp.com/api/';
    let options = {
        method: method,
        data: data
    }
    cordova.plugin.http.sendRequest(backend+url, options, function(response){
        success(JSON.parse(response.data));
    }, function(err){
        onerror(err.error);
    })
}

Jolly.initJquery = function(){
    //javascript dom and scope issues make this crucial to manage dropdown at profile
    $('.dropdown-toggle').bind('click', function(evt){
        $('.dropdown').show('fast');
    });
    $(document).click(function(evt){
        if(!$('.dropdown').is(':hidden') && evt.target.tagName !== 'I'){
            evt.stopPropagation();
            evt.preventDefault();
            $('.dropdown').fadeOut('fast');
        }
    });
}
