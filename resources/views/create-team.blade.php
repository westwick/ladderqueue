@extends('layouts.app')

@section('head')
    <style>
        .team-logo {
            margin-bottom: 1.25rem;
        }
        #imgcropper {
            display: none;
            border: 1px solid #dbdbdb;
            width: 250px;
            height: 250px;
            position:relative; /* or fixed or absolute */

            margin-bottom: 1rem;
            border: 1px solid #dbdbdb;
            box-sizing: content-box;
            -moz-box-sizing: content-box;

            background-repeat: no-repeat;
            background-position: center;
        }
        #croppicModal img {
            max-width: none;
        }

        /* DO NOT CHANGE FROM HERE ( unless u know what u are doing) */
        .cropImgWrapper{
            cursor: -webkit-grab;
            cursor: grab;
        }
        .cropImgWrapper:active{
            cursor: -webkit-grabbing;
            cursor: grabbing;
        }

        .cropImgUpload{
            z-index:2;
            position:absolute;
            height:28px;
            display:block;
            top: -30px;
            right: -2px;
            font-family:sans-serif;
            width:20px;
            height:20px;
            text-align:center;
            line-height:20px;
            color:#FFF;
        }

        .cropControls{
            z-index:2;
            position:absolute;
            height:30px;
            display:block;
            /* top: -31px; */
            top: -1px;
            right: -1px;
            font-family:sans-serif;
            background-color:rgba(0,0,0,0.35);
        }

        .cropControls i{
            display:block;
            float:left;
            margin:0;
            cursor:pointer;
            background-image:url('../images/cropperIcons.png');
            width:30px;
            height:30px;
            text-align:center;
            line-height:20px;
            color:#FFF;
            font-size:13px;
            font-weight: bold;
            font-style: normal;

        }

        .cropControls i:hover{ background-color:rgba(0,0,0,0.7);  }

        .cropControls i.cropControlZoomMuchIn{ background-position:0px 0px;}
        .cropControls i.cropControlZoomIn{ background-position:-30px 0px; }
        .cropControls i.cropControlZoomOut{ background-position:-60px 0px; }
        .cropControls i.cropControlZoomMuchOut{ background-position:-90px 0px; }
        .cropControls i.cropControlRotateLeft{ background-position:-210px 0px; }
        .cropControls i.cropControlRotateRight{ background-position:-240px 0px; }
        .cropControls i.cropControlCrop{ background-position:-120px 0px;}
        .cropControls i.cropControlUpload{ background-position:-150px 0px;}
        .cropControls i.cropControlReset{ background-position:-180px 0px;}
        .cropControls i.cropControlRemoveCroppedImage{ background-position:-180px 0px;}

        .cropControls i:last-child{
            margin-right:none;
        }

        #croppicModal{
            position:fixed;
            width:100%;
            height:100%;
            top: 0;
            left: 0;
            display:block;
            background:rgba(0,0,0,0.8);
            z-index: 10000;
        }
    </style>
@endsection

@section('content')
<div class="row main-top-padder padbot">
    <div class="medium-6 medium-centered columns">
        <div class="panel">
            <div class="create-team-form text-center">
                <form action="/create-team" method="post">
                    {{ csrf_field() }}
                    <h4>Create a New Team</h4>
                    <div class="form-group">
                        <input type="text" name="teamname" placeholder="Team Name" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="joinpw" placeholder="Password to join (for your teammates)" />
                    </div>
                    <div class="form-group">
                        {{--<a href="#" id="uploader_old" class="change change-user-photo">Update</a>--}}
                        <input type="text" class="logoplaceholder" name="logo" placeholder="Team Logo (select a file)" id="uploader" />
                        <div id="imgcropper"></div>
                        <input type="hidden" name="img" id="final-image" value="">
                        <img class="team-logo" src="http://placehold.it/250x250" />
                    </div>
                    <div class="form-group create-team-wrap">
                        <button type="submit" class="button">Create Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/croppic.min.js"></script>
    <script>
        $(function() {
            var cropperOptions = {
                uploadUrl:'/profile-image-upload',
                uploadData: {
                    "_token": window.Laravel.csrfToken
                },
                cropUrl:'/user-profile-image-save',
                modal:true,
                outputUrlId:'final-image',
                cropData: {
                    "_token": window.Laravel.csrfToken,
                    user: true
                },
                customUploadButtonId: 'uploader',
                onAfterImgCrop: function() {
                    $('#final-image').trigger('change');
                }
            };

            var cropperHeader = new Croppic('imgcropper', cropperOptions);

            $('#final-image').on('change', function() {
                $('.team-logo').attr('src', $(this).val());
                $('.logoplaceholder').val($(this).val());
            });
        });
    </script>
@endsection