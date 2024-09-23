@extends('frontend.layouts.frontend')

@section('content')


    <div class="container pt-5 pb-5">

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="r3f7Nb text-black" style="font-weight: 500">Tính năng trao đổi cùng chuyên gia của NEZTWORK thông qua Video Call</div>
                <div class="MZWksc">Kết nối với chuyên gia của NEZTWORK mà bạn đã đặt lịch</div>
                <form action="" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control mt-0" placeholder="Nhập mã cuộc họp đã gửi qua email của bạn.."
                               aria-label="Recipient's username" name="room" aria-describedby="basic-addon2">
                        <button type="submit" class="input-group-text bg-black text-white" id="basic-addon2 enter-room">Tham gia</button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-lg-6 text-center mt-5 mt-lg-0">
                <div class="item">
                    <img src="https://www.gstatic.com/meet/user_edu_get_a_link_light_90698cd7b4ca04d3005c962a3756c42d.svg" alt="" class="img-fluid">
                    <h5 class="mt-5">Tham gia cuộc họp cung với chuyên gia của Neztwork <br> để được bổ sung kiến thức.</h5>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('style')
    <link href="{{ asset('/storage/backend/main/css/chat/app.css')}}" rel="stylesheet">

    <style>
        .r3f7Nb {
            font-family: "Google Sans Display", Roboto, Arial, sans-serif;
            line-height: 3.25rem;
            font-size: 2.75rem;
            letter-spacing: 0;
            font-weight: 400;
            padding-bottom: .5em;
        }
        .MZWksc {
            font-family: "Google Sans", Roboto, Arial, sans-serif;
            line-height: 1.5rem;
            font-size: 1.125rem;
            letter-spacing: 0;
            font-weight: 400;
            color: rgb(95, 99, 104);
            max-width: 30rem;
            padding-bottom: 3em;
        }
    </style>
@endsection

@section('script')
    <script src="https://anocha.me/storage/frontend/js/socket.io.min.js" type="text/javascript"></script>
    <script src="{{ asset('/storage/backend')}}/js/chat/autolink.js"></script>
    <!--  ca 21-06-24 them chat video call     -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.3.0/adapter.min.js" integrity="sha256-2qQheewaqnZlXJ3RJRghVUwD/3fD9HNqxh4C+zvgmF4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js'></script>
    <script src='https://cdn.rawgit.com/yahoo/xss-filters/master/dist/xss-filters.js'></script>
    <script type="module">

        // import helpers from '{{ asset('/storage/backend')}}/js/chat/helpers.js';

        /*------HELPERS-------*/
        function generateRandomString() {
            const crypto = window.crypto || window.msCrypto;
            let array = new Uint32Array(1);

            return crypto.getRandomValues(array);
        }

        function  closeVideo( elemId ) {
            if ( document.getElementById( elemId ) ) {
                document.getElementById( elemId ).remove();
                adjustVideoElemSize();
            }
        }

        function pageHasFocus() {
            return !( document.hidden || document.onfocusout || window.onpagehide || window.onblur );
        }

        function getQString( url = '', keyToReturn = '' ) {

            url = url ? url : location.href;
            let queryStrings = decodeURIComponent( url ).split( '#', 2 )[0].split( '?', 2 )[1];

            if ( queryStrings ) {
                let splittedQStrings = queryStrings.split( '&' );

                if ( splittedQStrings.length ) {
                    let queryStringObj = {};

                    splittedQStrings.forEach( function ( keyValuePair ) {
                        let keyValue = keyValuePair.split( '=', 2 );

                        if ( keyValue.length ) {
                            queryStringObj[keyValue[0]] = keyValue[1];
                        }
                    } );

                    return keyToReturn ? ( queryStringObj[keyToReturn] ? queryStringObj[keyToReturn] : null ) : queryStringObj;
                }

                return null;
            }

            return null;
        }


        function userMediaAvailable() {

            console.log("userMediaAvailable==> "+ navigator.getUserMedia);

            return !!( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia );
        }


        function getUserFullMedia() {

            if (userMediaAvailable() ) {
                return navigator.mediaDevices.getUserMedia( {
                    video: true,
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true
                    }
                } );
            }

            else {
                throw new Error( 'User media not available' );
            }
        }


        function getUserAudio() {
            if ( userMediaAvailable() ) {
                return navigator.mediaDevices.getUserMedia( {
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true
                    }
                } );
            }

            else {
                throw new Error( 'User media not available' );
            }
        }


        function shareScreen() {
            if ( userMediaAvailable() ) {
                return navigator.mediaDevices.getDisplayMedia( {
                    video: {
                        cursor: "always"
                    },
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        sampleRate: 44100
                    }
                } );
            }

            else {
                throw new Error( 'User media not available' );
            }
        }


        function getIceServer() {
            return {
                iceServers: [
                    {
                        urls: ["stun:eu-turn4.xirsys.com"]
                    },
                    {
                        username: "ml0jh0qMKZKd9P_9C0UIBY2G0nSQMCFBUXGlk6IXDJf8G2uiCymg9WwbEJTMwVeiAAAAAF2__hNSaW5vbGVl",
                        credential: "4dd454a6-feee-11e9-b185-6adcafebbb45",
                        urls: [
                            "turn:eu-turn4.xirsys.com:80?transport=udp",
                            "turn:eu-turn4.xirsys.com:3478?transport=tcp"
                        ]
                    }
                ]
            };
        }


        function addChat( data, senderType ) {

            let chatMsgDiv = document.querySelector( '#chat-messages' );
            let contentAlign = 'justify-content-end';
            let senderName = 'You';
            let msgBg = 'bg-white';

            if ( senderType === 'remote' ) {
                contentAlign = 'justify-content-start';
                senderName = data.sender;
                msgBg = '';

                toggleChatNotificationBadge();
            }

            let infoDiv = document.createElement( 'div' );
            infoDiv.className = 'sender-info';
            infoDiv.innerText = `${ senderName } - ${ moment().format( 'Do MMMM, YYYY h:mm a' ) }`;

            let colDiv = document.createElement( 'div' );
            colDiv.className = `col-10 card chat-card msg ${ msgBg }`;
            colDiv.innerHTML = xssFilters.inHTMLData( data.msg ).autoLink( { target: "_blank", rel: "nofollow"});

            let rowDiv = document.createElement( 'div' );
            rowDiv.className = `row ${ contentAlign } mb-2`;


            colDiv.appendChild( infoDiv );
            rowDiv.appendChild( colDiv );

            chatMsgDiv.appendChild( rowDiv );

            /**
             * Move focus to the newly added message but only if:
             * 1. Page has focus
             * 2. User has not moved scrollbar upward. This is to prevent moving the scroll position if user is reading previous messages.
             */
            if ( pageHasFocus ) {
                rowDiv.scrollIntoView();
            }
        }


        function toggleChatNotificationBadge() {

            if ( document.querySelector( '#chat-pane' ).classList.contains( 'chat-opened' ) ) {
                document.querySelector( '#new-chat-notification' ).setAttribute( 'hidden', true );
            }

            else {
                document.querySelector( '#new-chat-notification' ).removeAttribute( 'hidden' );
            }
        }


        function  replaceTrack( stream, recipientPeer ) {

            let sender = recipientPeer.getSenders ? recipientPeer.getSenders().find( s => s.track && s.track.kind === stream.kind ) : false;

            sender ? sender.replaceTrack( stream ) : '';
        }


        function toggleShareIcons( share ) {

            let shareIconElem = document.querySelector( '#share-screen' );

            if ( share ) {
                shareIconElem.setAttribute( 'title', 'Stop sharing screen' );
                shareIconElem.children[0].classList.add( 'text-primary' );
                shareIconElem.children[0].classList.remove( 'text-white' );
            }

            else {
                shareIconElem.setAttribute( 'title', 'Share screen' );
                shareIconElem.children[0].classList.add( 'text-white' );
                shareIconElem.children[0].classList.remove( 'text-primary' );
            }
        }


        function toggleVideoBtnDisabled( disabled ) {
            document.getElementById( 'toggle-video' ).disabled = disabled;
        }


        function  maximiseStream( e ) {
            let elem = e.target.parentElement.previousElementSibling;

            elem.requestFullscreen() || elem.mozRequestFullScreen() || elem.webkitRequestFullscreen() || elem.msRequestFullscreen();
        }


        function  singleStreamToggleMute( e ) {
            if ( e.target.classList.contains( 'fa-microphone' ) ) {
                e.target.parentElement.previousElementSibling.muted = true;
                e.target.classList.add( 'fa-microphone-slash' );
                e.target.classList.remove( 'fa-microphone' );
            }

            else {
                e.target.parentElement.previousElementSibling.muted = false;
                e.target.classList.add( 'fa-microphone' );
                e.target.classList.remove( 'fa-microphone-slash' );
            }
        }


        function saveRecordedStream( stream, user ) {
            let blob = new Blob( stream, { type: 'video/webm' } );

            let file = new File( [blob], `${ user }-${ moment().unix() }-record.webm` );

            saveAs( file );
        }


        function toggleModal( id, show ) {
            let el = document.getElementById( id );

            if ( show ) {
                el.style.display = 'block';
                el.removeAttribute( 'aria-hidden' );
            }

            else {
                el.style.display = 'none';
                el.setAttribute( 'aria-hidden', true );
            }
        }


        function  setLocalStream( stream, mirrorMode = true ) {
            const localVidElem = document.getElementById( 'local' );

            localVidElem.srcObject = stream;
            mirrorMode ? localVidElem.classList.add( 'mirror-mode' ) : localVidElem.classList.remove( 'mirror-mode' );
        }


        function  adjustVideoElemSize() {
            let elem = document.getElementsByClassName( 'card' );
            let totalRemoteVideosDesktop = elem.length;
            let newWidth = totalRemoteVideosDesktop <= 2 ? '50%' : (
                totalRemoteVideosDesktop == 3 ? '33.33%' : (
                    totalRemoteVideosDesktop <= 8 ? '25%' : (
                        totalRemoteVideosDesktop <= 15 ? '20%' : (
                            totalRemoteVideosDesktop <= 18 ? '16%' : (
                                totalRemoteVideosDesktop <= 23 ? '15%' : (
                                    totalRemoteVideosDesktop <= 32 ? '12%' : '10%'
                                )
                            )
                        )
                    )
                )
            );


            for ( let i = 0; i < totalRemoteVideosDesktop; i++ ) {
                elem[i].style.width = newWidth;
            }
        }


        function   createDemoRemotes( str, total = 6 ) {
            let i = 0;

            let testInterval = setInterval( () => {
                let newVid = document.createElement( 'video' );
                newVid.id = `demo-${ i }-video`;
                newVid.srcObject = str;
                newVid.autoplay = true;
                newVid.className = 'remote-video';

                //video controls elements
                let controlDiv = document.createElement( 'div' );
                controlDiv.className = 'remote-video-controls';
                controlDiv.innerHTML = `<i class="fa fa-microphone text-white pr-3 mute-remote-mic" title="Mute"></i>
                <i class="fa fa-expand text-white expand-remote-video" title="Expand"></i>`;

                //create a new div for card
                let cardDiv = document.createElement( 'div' );
                cardDiv.className = 'card card-sm';
                cardDiv.id = `demo-${ i }`;
                cardDiv.appendChild( newVid );
                cardDiv.appendChild( controlDiv );

                //put div in main-section elem
                document.getElementById( 'videos' ).appendChild( cardDiv );

                adjustVideoElemSize();

                i++;

                if ( i == total ) {
                    clearInterval( testInterval );
                }
            }, 2000 );
        }

        /*------HELPERS-------*/

        /*------EVENTS-------*/
        //When the chat icon is clicked
        document.querySelector( '#toggle-chat-pane' ).addEventListener( 'click', ( e ) => {
            let chatElem = document.querySelector( '#chat-pane' );
            let mainSecElem = document.querySelector( '#main-section' );

            if ( chatElem.classList.contains( 'chat-opened' ) ) {
                chatElem.setAttribute( 'hidden', true );
                mainSecElem.classList.remove( 'col-md-9' );
                mainSecElem.classList.add( 'col-md-12' );
                chatElem.classList.remove( 'chat-opened' );
            }

            else {
                chatElem.attributes.removeNamedItem( 'hidden' );
                mainSecElem.classList.remove( 'col-md-12' );
                mainSecElem.classList.add( 'col-md-9' );
                chatElem.classList.add( 'chat-opened' );
            }

            //remove the 'New' badge on chat icon (if any) once chat is opened.
            setTimeout( () => {
                if ( document.querySelector( '#chat-pane' ).classList.contains( 'chat-opened' ) ) {
                    toggleChatNotificationBadge();
                }
            }, 300 );
        } );

        //When the video frame is clicked. This will enable picture-in-picture
        document.getElementById( 'local' ).addEventListener( 'click', () => {
            if ( !document.pictureInPictureElement ) {
                document.getElementById( 'local' ).requestPictureInPicture()
                    .catch( error => {
                        // Video failed to enter Picture-in-Picture mode.
                        console.error( error );
                    } );
            }

            else {
                document.exitPictureInPicture()
                    .catch( error => {
                        // Video failed to leave Picture-in-Picture mode.
                        console.error( error );
                    } );
            }
        } );

        //When the 'Create room" is button is clicked
        document.getElementById( 'create-room' ).addEventListener( 'click', ( e ) => {
            e.preventDefault();

            let roomName = document.querySelector( '#room-name' ).value;
            let yourName = document.querySelector( '#your-name' ).value;

            if ( roomName && yourName ) {
                //remove error message, if any
                document.querySelector('#err-msg').innerText = "";

                //save the user's name in sessionStorage
                sessionStorage.setItem( 'username', yourName );

                //create room link
                let roomLink = `${ location.origin }/chat.html?room=${ roomName.trim().replace( ' ', '_' ) }_${ generateRandomString() }`;

                //show message with link to room
                document.querySelector( '#room-created' ).innerHTML = `Room successfully created. Click <a href='${ roomLink }'>here</a> to enter room.
                Share the room link with your partners.`;

                //empty the values
                document.querySelector( '#room-name' ).value = '';
                document.querySelector( '#your-name' ).value = '';
            }

            else {
                document.querySelector('#err-msg').innerText = "All fields are required";
            }
        } );

        //When the 'Enter room' button is clicked.
        // document.getElementById( 'enter-room' ).addEventListener( 'click', ( e ) => {
        //     e.preventDefault();
        //
        //     let name = document.querySelector( '#username' ).value;
        //
        //     if ( name ) {
        //         //remove error message, if any
        //         document.querySelector('#err-msg-username').innerText = "";
        //
        //         //save the user's name in sessionStorage
        //         sessionStorage.setItem( 'username', name );
        //
        //         //reload room
        //         location.reload();
        //     }
        //
        //     else {
        //         document.querySelector('#err-msg-username').innerText = "Please input your name";
        //     }
        // } );
        //
        document.addEventListener('DOMContentLoaded', function () {
            // Kiểm tra xem đã lưu username vào sessionStorage chưa
            if (!sessionStorage.getItem('username')) {
                // Nếu chưa lưu, thực hiện lưu username vào sessionStorage
                sessionStorage.setItem('username', 'name');
                location.reload();
            } else  {
                return;
            }

        });
        //

        document.addEventListener( 'click', ( e ) => {
            if ( e.target && e.target.classList.contains( 'expand-remote-video' ) ) {
                maximiseStream( e );
            }

            else if ( e.target && e.target.classList.contains( 'mute-remote-mic' ) ) {
                singleStreamToggleMute( e );
            }
        } );

        document.getElementById( 'closeModal' ).addEventListener( 'click', () => {
            toggleModal( 'recording-options-modal', false );
        } );

        /*------EVENTS-------*/


        window.addEventListener( 'load', () => {

            const room =getQString( location.href, 'room' );
            const username = sessionStorage.getItem( 'username' );

            console.log('getQString: ' + username);

            if ( !room ) {
                document.querySelector( '#room-create' ).attributes.removeNamedItem( 'hidden' );
            }

            else if ( !username ) {
                document.querySelector( '#username-set' ).attributes.removeNamedItem( 'hidden' );
            }

            else {


                let commElem = document.getElementsByClassName( 'room-comm' );

                for ( let i = 0; i < commElem.length; i++ ) {
                    commElem[i].attributes.removeNamedItem( 'hidden' );
                }

                var pc = [];

                // var socket = io.connect('ws://chatneztwork.dev24h.net:3000', {transports: ["websocket"]});
                var socket = io.connect('wss://chatnetwork.dev24h.net', {transports: ["websocket"]});
                //let socket = io( '/stream' );

                var socketId = '';
                var randomNumber = `__${generateRandomString()}__${generateRandomString()}__`;
                var myStream = '';
                var screen = '';
                var recordedStream = [];
                var mediaRecorder = '';


                socket.on( 'connect', () => {

                    //set socketId
                    socketId = socket.io.engine.id;


                    document.getElementById('randomNumber').innerText = randomNumber;


                    socket.emit( 'subscribe', {
                        room: room,
                        socketId: socketId
                    } );


                    socket.on( 'new user', ( data ) => {

                        socket.emit( 'newUserStart', { to: data.socketId, sender: socketId } );
                        pc.push( data.socketId );
                        init( true, data.socketId );
                        console.log(" --- new user---- ");
                    } );


                    socket.on( 'newUserStart', ( data ) => {

                        pc.push( data.sender );
                        init( false, data.sender );
                        console.log(" --- new user---- ");

                    } );


                    socket.on( 'ice candidates', async ( data ) => {
                        data.candidate ? await pc[data.sender].addIceCandidate( new RTCIceCandidate( data.candidate ) ) : '';
                        console.log(" --- ice candidates---- ");
                    } );


                    socket.on( 'sdp', async ( data ) => {
                        if ( data.description.type === 'offer' ) {
                            data.description ? await pc[data.sender].setRemoteDescription( new RTCSessionDescription( data.description ) ) : '';

                            getUserFullMedia().then( async ( stream ) => {
                                if ( !document.getElementById( 'local' ).srcObject ) {
                                    setLocalStream( stream );
                                }

                                //save my stream
                                myStream = stream;

                                stream.getTracks().forEach( ( track ) => {
                                    pc[data.sender].addTrack( track, stream );
                                } );

                                let answer = await pc[data.sender].createAnswer();

                                await pc[data.sender].setLocalDescription( answer );

                                socket.emit( 'sdp', { description: pc[data.sender].localDescription, to: data.sender, sender: socketId } );
                                console.log(" --- data.description.type === 'offer'---- ");
                            } ).catch( ( e ) => {
                                console.error( e );
                            } );
                        }

                        else if ( data.description.type === 'answer' ) {
                            await pc[data.sender].setRemoteDescription( new RTCSessionDescription( data.description ) );
                            console.log("data.description.type === 'answer");
                        }
                    } );


                    socket.on( 'chat', ( data ) => {
                        addChat( data, 'remote' );
                    } );


                } );


                function init( createOffer, partnerName ) {


                    pc[partnerName] = new RTCPeerConnection( getIceServer() );

                    if ( screen && screen.getTracks().length ) {
                        screen.getTracks().forEach( ( track ) => {
                            pc[partnerName].addTrack( track, screen );//should trigger negotiationneeded event
                        } );
                    }

                    else if ( myStream ) {
                        myStream.getTracks().forEach( ( track ) => {
                            pc[partnerName].addTrack( track, myStream );//should trigger negotiationneeded event
                        } );
                    }

                    else {
                        console.log("getUserFullMedia==> ");
                        getUserFullMedia().then( ( stream ) => {
                            //save my stream
                            myStream = stream;

                            stream.getTracks().forEach( ( track ) => {
                                pc[partnerName].addTrack( track, stream );//should trigger negotiationneeded event
                            } );

                            setLocalStream( stream );
                        } ).catch( ( e ) => {
                            console.error( `stream error: ${ e }` );
                        } );
                    }



                    //create offer
                    if ( createOffer ) {
                        pc[partnerName].onnegotiationneeded = async () => {
                            let offer = await pc[partnerName].createOffer();

                            await pc[partnerName].setLocalDescription( offer );

                            socket.emit( 'sdp', { description: pc[partnerName].localDescription, to: partnerName, sender: socketId } );
                        };
                    }



                    //send ice candidate to partnerNames
                    pc[partnerName].onicecandidate = ( { candidate } ) => {
                        socket.emit( 'ice candidates', { candidate: candidate, to: partnerName, sender: socketId } );
                    };



                    //add
                    pc[partnerName].ontrack = ( e ) => {
                        let str = e.streams[0];
                        if ( document.getElementById( `${ partnerName }-video` ) ) {
                            document.getElementById( `${ partnerName }-video` ).srcObject = str;
                        }

                        else {
                            //video elem
                            let newVid = document.createElement( 'video' );
                            newVid.id = `${ partnerName }-video`;
                            newVid.srcObject = str;
                            newVid.autoplay = true;
                            newVid.className = 'remote-video';

                            //video controls elements
                            let controlDiv = document.createElement( 'div' );
                            controlDiv.className = 'remote-video-controls';
                            controlDiv.innerHTML = `<i class="fa fa-microphone text-white pr-3 mute-remote-mic" title="Mute"></i>
                        <i class="fa fa-expand text-white expand-remote-video" title="Expand"></i>`;

                            //create a new div for card
                            let cardDiv = document.createElement( 'div' );
                            cardDiv.className = 'card card-sm';
                            cardDiv.id = partnerName;
                            cardDiv.appendChild( newVid );
                            cardDiv.appendChild( controlDiv );

                            //put div in main-section elem
                            document.getElementById( 'videos' ).appendChild( cardDiv );

                            adjustVideoElemSize();
                        }
                    };



                    pc[partnerName].onconnectionstatechange = ( d ) => {
                        switch ( pc[partnerName].iceConnectionState ) {
                            case 'disconnected':
                            case 'failed':
                                closeVideo( partnerName );
                                break;

                            case 'closed':
                                closeVideo( partnerName );
                                break;
                        }
                    };



                    pc[partnerName].onsignalingstatechange = ( d ) => {
                        switch ( pc[partnerName].signalingState ) {
                            case 'closed':
                                console.log( "Signalling state is 'closed'" );
                                closeVideo( partnerName );
                                break;
                        }
                    };
                    //--------------

                }

                //Get user video by default
                getAndSetUserStream();

                function getAndSetUserStream() {
                    getUserFullMedia().then( ( stream ) => {
                        //save my stream
                        myStream = stream;

                        setLocalStream( stream );
                    } ).catch( ( e ) => {
                        console.error( `stream error: ${ e }` );
                    } );
                }


                function sendMsg( msg ) {
                    let data = {
                        room: room,
                        msg: msg,
                        sender: `${username} (${randomNumber})`
                    };

                    //emit chat message
                    socket.emit( 'chat', data );

                    //add localchat
                    addChat( data, 'local' );
                }


                function stopSharingScreen() {
                    //enable video toggle btn
                    toggleVideoBtnDisabled( false );

                    return new Promise( ( res, rej ) => {
                        screen.getTracks().length ? screen.getTracks().forEach( track => track.stop() ) : '';

                        res();
                    } ).then( () => {
                        toggleShareIcons( false );
                        broadcastNewTracks( myStream, 'video' );
                    } ).catch( ( e ) => {
                        console.error( e );
                    } );
                }

                function broadcastNewTracks( stream, type, mirrorMode = true ) {
                    setLocalStream( stream, mirrorMode );

                    let track = type == 'audio' ? stream.getAudioTracks()[0] : stream.getVideoTracks()[0];

                    for ( let p in pc ) {
                        let pName = pc[p];

                        if ( typeof pc[pName] == 'object' ) {
                            replaceTrack( track, pc[pName] );
                        }
                    }
                }


                function toggleRecordingIcons( isRecording ) {
                    let e = document.getElementById( 'record' );

                    if ( isRecording ) {
                        e.setAttribute( 'title', 'Stop recording' );
                        e.children[0].classList.add( 'text-danger' );
                        e.children[0].classList.remove( 'text-white' );
                    }

                    else {
                        e.setAttribute( 'title', 'Record' );
                        e.children[0].classList.add( 'text-white' );
                        e.children[0].classList.remove( 'text-danger' );
                    }
                }


                function startRecording( stream ) {
                    mediaRecorder = new MediaRecorder( stream, {
                        mimeType: 'video/webm;codecs=vp9'
                    } );

                    mediaRecorder.start( 1000 );
                    toggleRecordingIcons( true );

                    mediaRecorder.ondataavailable = function ( e ) {
                        recordedStream.push( e.data );
                    };

                    mediaRecorder.onstop = function () {
                        toggleRecordingIcons( false );

                        saveRecordedStream( recordedStream, username );

                        setTimeout( () => {
                            recordedStream = [];
                        }, 3000 );
                    };

                    mediaRecorder.onerror = function ( e ) {
                        console.error( e );
                    };
                }

                document.getElementById('chat-input-btn').addEventListener('click',(e) => {
                    console.log("here: ",document.getElementById('chat-input').value)
                    if (  document.getElementById('chat-input').value.trim()  ) {
                        sendMsg( document.getElementById('chat-input').value );

                        setTimeout( () => {
                            document.getElementById('chat-input').value = '';
                        }, 50 );
                    }
                });

                //Chat textarea
                document.getElementById( 'chat-input' ).addEventListener( 'keypress', ( e ) => {
                    if ( e.which === 13 && ( e.target.value.trim() ) ) {
                        e.preventDefault();

                        sendMsg( e.target.value );

                        setTimeout( () => {
                            e.target.value = '';
                        }, 50 );
                    }
                } );


                //When the video icon is clicked
                document.getElementById( 'toggle-video' ).addEventListener( 'click', ( e ) => {
                    e.preventDefault();

                    let elem = document.getElementById( 'toggle-video' );

                    if ( myStream.getVideoTracks()[0].enabled ) {
                        e.target.classList.remove( 'fa-video' );
                        e.target.classList.add( 'fa-video-slash' );
                        elem.setAttribute( 'title', 'Show Video' );

                        myStream.getVideoTracks()[0].enabled = false;
                    }

                    else {
                        e.target.classList.remove( 'fa-video-slash' );
                        e.target.classList.add( 'fa-video' );
                        elem.setAttribute( 'title', 'Hide Video' );

                        myStream.getVideoTracks()[0].enabled = true;
                    }

                    broadcastNewTracks( myStream, 'video' );
                } );


                //When the mute icon is clicked
                document.getElementById( 'toggle-mute' ).addEventListener( 'click', ( e ) => {
                    e.preventDefault();

                    let elem = document.getElementById( 'toggle-mute' );

                    if ( myStream.getAudioTracks()[0].enabled ) {
                        e.target.classList.remove( 'fa-microphone-alt' );
                        e.target.classList.add( 'fa-microphone-alt-slash' );
                        elem.setAttribute( 'title', 'Unmute' );

                        myStream.getAudioTracks()[0].enabled = false;
                    }

                    else {
                        e.target.classList.remove( 'fa-microphone-alt-slash' );
                        e.target.classList.add( 'fa-microphone-alt' );
                        elem.setAttribute( 'title', 'Mute' );

                        myStream.getAudioTracks()[0].enabled = true;
                    }

                    broadcastNewTracks( myStream, 'audio' );
                } );


                //When user clicks the 'Share screen' button
                document.getElementById( 'share-screen' ).addEventListener( 'click', ( e ) => {
                    e.preventDefault();

                    if ( screen && screen.getVideoTracks().length && screen.getVideoTracks()[0].readyState != 'ended' ) {
                        stopSharingScreen();
                    }

                    else {
                        shareScreen();
                    }
                } );


                //When record button is clicked
                document.getElementById( 'record' ).addEventListener( 'click', ( e ) => {
                    /**
                     * Ask user what they want to record.
                     * Get the stream based on selection and start recording
                     */
                    if ( !mediaRecorder || mediaRecorder.state == 'inactive' ) {
                        toggleModal( 'recording-options-modal', true );
                    }

                    else if ( mediaRecorder.state == 'paused' ) {
                        mediaRecorder.resume();
                    }

                    else if ( mediaRecorder.state == 'recording' ) {
                        mediaRecorder.stop();
                    }
                } );


                //When user choose to record screen
                document.getElementById( 'record-screen' ).addEventListener( 'click', () => {
                    toggleModal( 'recording-options-modal', false );

                    if ( screen && screen.getVideoTracks().length ) {
                        startRecording( screen );
                    }

                    else {
                        shareScreen().then( ( screenStream ) => {
                            startRecording( screenStream );
                        } ).catch( () => { } );
                    }
                } );


                //When user choose to record own video
                document.getElementById( 'record-video' ).addEventListener( 'click', () => {
                    toggleModal( 'recording-options-modal', false );

                    if ( myStream && myStream.getTracks().length ) {
                        startRecording( myStream );
                    }

                    else {
                        getUserFullMedia().then( ( videoStream ) => {
                            startRecording( videoStream );
                        } ).catch( () => { } );
                    }
                } );



            }

        } );

    </script>
@endsection

