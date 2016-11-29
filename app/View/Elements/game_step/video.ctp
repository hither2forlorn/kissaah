<?php
$answer = 'http://placehold.it/300x300&text=X';
if(empty($selfdata['Configuration']['dependent_id'])) {
	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$answer = '/files/img/medium/' . $selfdata['Game'][0]['Game']['answer'];
	}
	$id = $selfdata['Configuration']['id'];
	
} else {
	if(!empty($selfdata['Dependent'][0]['answer'])) {
		$answer = '/files/img/medium/' . $selfdata['Dependent'][0]['answer'];
	}
	$id = $selfdata['Configuration']['dependent_id'];
}
$image = $this->Html->image($answer, array('class' => 'img-responsive margin-bottom-5', 'data' => 'medium-' . $id));

$actions = '';
if($summary) {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box-summary';
	
} else {
	$image_class = 'col-md-4 col-sm-4 col-xs-8 padding-0 image-box';
	
	$actions  = $this->Form->create('Game' . $id . 'Upload', array('class' => 'btn-file pull-left fileupload'));
	$actions .= $this->Html->tag('i', '', array('class' => 'fa fa-upload fa-2x')) . '&nbsp;';
	//$actions .= $this->Html->image('Upload.png', array('id' => 'upl' . $id));
	$actions .= $this->Form->input($id, array('type' => 'file', 'label' => false, 'class' => 'default', 'div' => false));
	$actions .= $this->Form->end();
	$actions .= $this->Html->link(
			$this->Html->tag('i', '', array('class' => 'fa fa-pinterest fa-2x', 'title' => 'Get Images From Pinterest')),
			array('controller' => 'games', 'action' => 'pinterest_getimages', '?' => array('cid' => $id)),
			array('escape' => false)) . '&nbsp;';
			//$actions .= $this->Html->image('pinterest.png', array('title' => 'Get Images From Pinterest', 'data' => $id, 'id' => 'pin'));
	$actions .= $this->Html->link(
			$this->Html->tag('i', '', array('class' => 'fa fa-instagram fa-2x', 'title' => 'Get Images From Instagram')),
			array('controller' => 'games', 'action' => 'instagram_getImages', '?' => array('cid' => $id, 'game_step' => $this->request->query['st'])),
			array('escape' => false)) . '&nbsp;';
			//$actions .= $this->Html->image('Instagram.png', array('title' => 'Get Images From Instagram', 'data' => $id, 'id' => 'ins'));

	if(!empty($selfdata['Game'][0]['Game']['answer'])) {
		$actions .= $this->Html->link(
				$this->Html->tag('i', '', array('class' => 'fa fa-remove fa-2x', 'title' => 'Remove Image')),
				array('controller' => 'games', 'action' => 'remove_image', $id),
				array('escape' => false)) . '&nbsp;';
				//$actions .= $this->Html->image('removeimage.png', array('title' => 'Remove', 'data' => $id, 'id' => 'rem'));
	}
	$image .= $this->Html->div('image-icon col-md-12 col-xs-12', $actions, array('id' => 'tour-step-04'));
}

$child_field = '';
if(isset($selfdata['children'])) {
	foreach($selfdata['children'] as $child) {
		$child_field = $this->Render->display($child['Configuration']['type'], $child, 1, $summary, true);
	}
}

if($selfdata['Configuration']['sub_txt'] != '') {
	$image_class = str_replace('col-md-4', 'col-md-3', $image_class);
	echo $this->Html->div('col-md-9 col-sm-8 col-xs-12 padding-left-0', $selfdata['Configuration']['sub_txt'] . $child_field);
	echo $this->Html->div($image_class, $image);
	
} else {
	if($count == 1) {
		$image_class .= ' col-md-offset-4';
	}
	echo $this->Html->div($image_class, $image . $child_field);
	
}

$screen_size = $this->Session->read('Screen.width');
?>    
    
    
    <style>
        .recordrtc option[disabled] {
            display: none;
        }
    </style>

    <script src="https://cdn.webrtc-experiment.com/RecordRTC.js"></script>

    <!-- for Edge/FF/Chrome/Opera/etc. getUserMedia support -->
    <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>

        <section class="experiment recordrtc">
                <select class="recording-media"></select>

                into
                <select class="media-container-format">
                    <option>WebM</option>
                    <option disabled>Mp4</option>
                    <option disabled>WAV</option>
                    <option disabled>Ogg</option>
                    <option>Gif</option>
                </select>

                <button>Start Recording</button>

            <div style="text-align: center; display: none;">
                <button id="save-to-disk">Save To Disk</button>
                <button id="open-new-tab">Open New Tab</button>
            </div>

            <br>

            <video controls muted></video>
        </section>

        <script>
            (function() {
                var params = {},
                    r = /([^&=]+)=?([^&]*)/g;

                function d(s) {
                    return decodeURIComponent(s.replace(/\+/g, ' '));
                }

                var match, search = window.location.search;
                while (match = r.exec(search.substring(1))) {
                    params[d(match[1])] = d(match[2]);

                    if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                        params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                    }
                }

                window.params = params;
            })();

            function addStreamStopListener(stream, callback) {
                var streamEndedEvent = 'ended';

                if ('oninactive' in stream) {
                    streamEndedEvent = 'inactive';
                }

                stream.addEventListener(streamEndedEvent, function() {
                    callback();
                    callback = function() {};
                }, false);

                stream.getAudioTracks().forEach(function(track) {
                    track.addEventListener(streamEndedEvent, function() {
                        callback();
                        callback = function() {};
                    }, false);
                });

                stream.getVideoTracks().forEach(function(track) {
                    track.addEventListener(streamEndedEvent, function() {
                        callback();
                        callback = function() {};
                    }, false);
                });
            }
        </script>

        <script>
            function intallFirefoxScreenCapturingExtension() {
                InstallTrigger.install({
                    'Foo': {
                        // URL: 'https://addons.mozilla.org/en-US/firefox/addon/enable-screen-capturing/',
                        URL: 'https://addons.mozilla.org/firefox/downloads/file/355418/enable_screen_capturing_in_firefox-1.0.006-fx.xpi?src=cb-dl-hotness',
                        toString: function() {
                            return this.URL;
                        }
                    }
                });
            }

            var recordingDIV = document.querySelector('.recordrtc');
            var recordingMedia = recordingDIV.querySelector('.recording-media');
            var recordingPlayer = recordingDIV.querySelector('video');
            var mediaContainerFormat = recordingDIV.querySelector('.media-container-format');

            window.onbeforeunload = function() {
                recordingDIV.querySelector('button').disabled = false;
                recordingMedia.disabled = false;
                mediaContainerFormat.disabled = false;
            };

            recordingDIV.querySelector('button').onclick = function() {
                var button = this;

                if(button.innerHTML === 'Stop Recording') {
                    button.disabled = true;
                    button.disableStateWaiting = true;
                    setTimeout(function() {
                        button.disabled = false;
                        button.disableStateWaiting = false;
                    }, 2 * 1000);

                    button.innerHTML = 'Star Recording';

                    function stopStream() {
                        if(button.stream && button.stream.stop) {
                            button.stream.stop();
                            button.stream = null;
                        }
                    }

                    if(button.recordRTC) {
                        if(button.recordRTC.length) {
                            button.recordRTC[0].stopRecording(function(url) {
                                if(!button.recordRTC[1]) {
                                    button.recordingEndedCallback(url);
                                    stopStream();

                                    saveToDiskOrOpenNewTab(button.recordRTC[0]);
                                    return;
                                }

                                button.recordRTC[1].stopRecording(function(url) {
                                    button.recordingEndedCallback(url);
                                    stopStream();
                                });
                            });
                        }
                        else {
                            button.recordRTC.stopRecording(function(url) {
                                button.recordingEndedCallback(url);
                                stopStream();

                                saveToDiskOrOpenNewTab(button.recordRTC);
                            });
                        }
                    }

                    return;
                }

                button.disabled = true;

                var commonConfig = {
                    onMediaCaptured: function(stream) {
                        button.stream = stream;
                        if(button.mediaCapturedCallback) {
                            button.mediaCapturedCallback();
                        }

                        button.innerHTML = 'Stop Recording';
                        button.disabled = false;
                    },
                    onMediaStopped: function() {
                        button.innerHTML = 'Start Recording';

                        if(!button.disableStateWaiting) {
                            button.disabled = false;
                        }
                    },
                    onMediaCapturingFailed: function(error) {
                        if(error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                            intallFirefoxScreenCapturingExtension();
                        }

                        commonConfig.onMediaStopped();
                    }
                };

                var mimeType = 'video/webm';
                if(mediaContainerFormat.value === 'Mp4') {
                    mimeType = 'video/mp4';
                }

                if(recordingMedia.value === 'record-audio-plus-video') {
                    captureAudioPlusVideo(commonConfig);

                    button.mediaCapturedCallback = function() {

                        if(typeof MediaRecorder === 'undefined') { // opera or chrome etc.
                            button.recordRTC = [];

                            if(!params.bufferSize) {
                                // it fixes audio issues whilst recording 720p
                                params.bufferSize = 16384;
                            }

                            var options = {
                                type: 'audio',
                                bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                                sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                                leftChannel: params.leftChannel || false,
                                disableLogs: params.disableLogs || false,
                                recorderType: webrtcDetectedBrowser === 'edge' ? StereoAudioRecorder : null
                            };

                            if(typeof params.sampleRate == 'undefined') {
                                delete options.sampleRate;
                            }

                            var audioRecorder = RecordRTC(button.stream, options);

                            var videoRecorder = RecordRTC(button.stream, {
                                type: 'video',
                                disableLogs: params.disableLogs || false,
                                canvas: {
                                    width: params.canvas_width || 320,
                                    height: params.canvas_height || 240
                                },
                                frameInterval: typeof params.frameInterval !== 'undefined' ? parseInt(params.frameInterval) : 20 // minimum time between pushing frames to Whammy (in milliseconds)
                            });

                            // to sync audio/video playbacks in browser!
                            videoRecorder.initRecorder(function() {
                                audioRecorder.initRecorder(function() {
                                    audioRecorder.startRecording();
                                    videoRecorder.startRecording();
                                });
                            });

                            button.recordRTC.push(audioRecorder, videoRecorder);

                            button.recordingEndedCallback = function() {
                                var audio = new Audio();
                                audio.src = audioRecorder.toURL();
                                audio.controls = true;
                                audio.autoplay = true;

                                audio.onloadedmetadata = function() {
                                    recordingPlayer.src = videoRecorder.toURL();
                                    recordingPlayer.play();
                                };

                                recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                                recordingPlayer.parentNode.appendChild(audio);

                                if(audio.paused) audio.play();
                            };
                            return;
                        }

                        button.recordRTC = RecordRTC(button.stream, {
                            type: 'video',
                            mimeType: mimeType,
                            disableLogs: params.disableLogs || false,
                            // bitsPerSecond: 25 * 8 * 1025 // 25 kbits/s
                            getNativeBlob: false // enable it for longer recordings
                        });

                        button.recordingEndedCallback = function(url) {
                            recordingPlayer.muted = false;
                            recordingPlayer.removeAttribute('muted');
                            recordingPlayer.src = url;
                            recordingPlayer.play();

                            recordingPlayer.onended = function() {
                                recordingPlayer.pause();
                                recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                            };
                        };

                        button.recordRTC.startRecording();
                    };
                }
            };

            function captureAudioPlusVideo(config) {
                captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
                    recordingPlayer.srcObject = audioVideoStream;
                    recordingPlayer.play();

                    config.onMediaCaptured(audioVideoStream);

                    addStreamStopListener(audioVideoStream, function() {
                        config.onMediaStopped();
                    });
                }, function(error) {
                    config.onMediaCapturingFailed(error);
                });
            }

            function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                var isBlackBerry = !!(/BB10|BlackBerry/i.test(navigator.userAgent || ''));
                if(isBlackBerry && !!(navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia)) {
                    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                    navigator.getUserMedia(mediaConstraints, successCallback, errorCallback);
                    return;
                }

                navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
            }

            function setMediaContainerFormat(arrayOfOptionsSupported) {
                var options = Array.prototype.slice.call(
                    mediaContainerFormat.querySelectorAll('option')
                );

                var selectedItem;
                options.forEach(function(option) {
                    option.disabled = true;

                    if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                        option.disabled = false;

                        if(!selectedItem) {
                            option.selected = true;
                            selectedItem = option;
                        }
                    }
                });
            }

            recordingMedia.onchange = function() {
                var options = [];
                if(webrtcDetectedBrowser === 'firefox') {
                    if(this.value === 'record-audio') {
                        options.push('Ogg');
                    }
                    else {
                        options.push('WebM', 'Mp4');
                    }

                    setMediaContainerFormat(options);
                    return;
                }
                if(this.value === 'record-audio') {
                    setMediaContainerFormat(['WAV', 'Ogg']);
                    return;
                }
                setMediaContainerFormat(['WebM', 'Mp4', 'Ogg']);
            };

            if(webrtcDetectedBrowser === 'edge') {
                // webp isn't supported in Microsoft Edge
                // neither MediaRecorder API
                // so lets disable both video/screen recording options

                console.warn('Neither MediaRecorder API nor webp is supported in Microsoft Edge. You cam merely record audio.');

                recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
                setMediaContainerFormat(['WAV']);
            }

            if(webrtcDetectedBrowser === 'firefox') {
                // Firefox implemented both MediaRecorder API as well as WebAudio API
                // Their MediaRecorder implementation supports both audio/video recording in single container format
                // Remember, we can't currently pass bit-rates or frame-rates values over MediaRecorder API (their implementation lakes these features)

                recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>' + recordingMedia.innerHTML;

                setMediaContainerFormat(['WebM', 'Mp4']);
            }

            if(webrtcDetectedBrowser === 'chrome') {
                recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>' + recordingMedia.innerHTML;

                if(typeof MediaRecorder === 'undefined') {
                    console.info('This RecordRTC demo merely tries to playback recorded audio/video sync inside the browser. It still generates two separate files (WAV/WebM).');
                }
            }

            function saveToDiskOrOpenNewTab(recordRTC) {
                recordingDIV.querySelector('#save-to-disk').parentNode.style.display = 'block';
                recordingDIV.querySelector('#save-to-disk').onclick = function() {
                    if(!recordRTC) return alert('No recording found.');

                    recordRTC.save();
                };

                recordingDIV.querySelector('#open-new-tab').onclick = function() {
                    if(!recordRTC) return alert('No recording found.');

                    window.open(recordRTC.toURL());
                };
            }
        </script>