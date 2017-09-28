<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/public/config_top.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/html.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/public/function.php');
$noper = 1;
require_once($_SERVER['DOCUMENT_ROOT'] . '/xamember/incluce/session.php');


$_SESSION['isMobile']	 = 1;
$ism					 = 1;
$m						 = '/m';

$headtitle = "视频介绍";

require_once($_SERVER['DOCUMENT_ROOT'] . '/m/template/incluce/header.php');
?>

<style>
           .bad-video {
            position: relative;
            overflow: hidden;
            background-color: #CCCCCC;
        }
        
        .bad-video .vplay{
            position: absolute;
            width: 15%;
            z-index: 99;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        
        .bad-video .controls {
                    width: 100%;
                    height: 2rem;
                    line-height: 2rem;
                    font-size: 0.8rem;
                    color: white;
                    display: block;
                    position: absolute;
                    bottom: 0;
                    background-color: rgba(0, 0, 0, .55);
                    display: -webkit-flex;
                    display: flex;
                }
                
                .bad-video .controls>* {
                    flex: 1;
                }
                
                .bad-video .controls>*:nth-child(1) {
                    flex: 6;
                }
                
                .bad-video .controls>*:nth-child(2) {
                    flex: 2;
                    text-align: center;
                }
                
                .bad-video .controls .progressBar {
                    margin: .75rem 5%;
                    position: relative;
                    width: 90%;
                    height: .5rem;
                    background-color: rgba(200, 200, 200, .55);
                    border-radius: 10px;
                }
                
                .bad-video .controls .timeBar {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 0;
                    height: 100%;
                    background-color: rgba(99, 110, 225, .85);
                    border-radius: 10px;
                }

        </style>
	<div class="bc-bg" tabindex="0" data-control="PAGE" id="Page" style="background:#eeeeee">
		<div class="uh cc-head  ubb bc-border" data-control="HEADER" id="Header">
			<div class="ub">
				<div class="nav-btn" id="nav-left">
					<div class="fa fa-1g fa-chevron-left ub-img1" onclick="window.history.go( - 1)">
					</div>
				</div>
				<h1 class="ut ub-f1 ulev-3 ut-s tx-c" tabindex="0">视频介绍</h1>
				<div class="nav-btn" id="nav-right">

				</div>
			</div>


		</div>

		<div class="uf sc-bg  bc-border" style="background: #FFFFFF;top: 6em;">
                <div class="bad-video">
                    <video class="" webkit-playsinline style="object-fit:fill; width: 100%;" controls autobuffer>
                        <source src='http://cdn.jbuy.com.au/jbuy.mp4' type="video/mp4"></source>
                        <p>设备不支持</p>
                    <video>
                    <img src="img/play.png" class="vplay" />
                    <div class="controls">
                        <div>
                            <div class="progressBar">
                                <div class="timeBar"></div>
                            </div>
                        </div>
                        <div><span class="current">00:00</span>/<span class="duration">00:00</span></div>
                        <div><span class="fill">全屏</span></div>
                    </div>
                </div>
            </div>
	</div>