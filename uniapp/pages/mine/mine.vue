<template>
	<view>

		<view class="mainBox bg-white">
			<view class="text-xxl" style="height: 486rpx; position: relative;">
				<image src='/static/images/my-bg2.png' mode='widthFix' class='png' style='width:100%;height:486rpx'>
				</image>
				<image class="logoImg rocket rocket-sussuspension" :src="login ? avatarUrl :  '../../static/logo.png'"
					@click="showTos()">
				</image>
				<view class="logoName rocket rocket-sussuspension text-white text-bold text-xl" @click="showTos()">
					{{login ? userInfo.nickName : '点击此处完善信息'}}
				</view>
			</view>
		</view>



		<view class="menu u-m-l-40 u-m-r-40  border-box whites">
			<button class="u-flex u-row-between u-p-30" hover-class="hover-class1" hover-stay-time="50"
				open-type="share">
				<view class="u-flex u-row-left">
					<image src="/static/icon/user_1.png"></image>
					<view class="u-p-l-20">分享小程序</view>
				</view>
				<view class="u-flex u-row-right">
					<view class="arror-right"></view>
				</view>
			</button>
		</view>

		<view class="menu u-m-l-40 u-m-r-40 u-m-t-40 border-box whites">
			<view class="u-flex u-row-between u-p-30 border-bottom" hover-class="hover-class1" hover-stay-time="50"
				@click="NavigateTos('/pages/mine/instructions')">
				<view class="u-flex u-row-left">
					<image src="/static/icon/user_2.png"></image>
					<view class="u-p-l-20">使用说明</view>
				</view>
				<view class="u-flex u-row-right">
					<view class="arror-right"></view>
				</view>
			</view>
			<button class="u-flex u-row-between u-p-30 border-bottom " hover-class="hover-class1" hover-stay-time="50"
				open-type="contact">
				<view class="u-flex u-row-left">
					<image src="/static/icon/user_4.png"></image>
					<view class="u-p-l-20">在线客服</view>
				</view>
				<view class="u-flex u-row-right">
					<view class="arror-right"></view>
				</view>
			</button>
		</view>
		<view class="menu u-m-l-40 u-m-r-40 u-m-t-40 border-box whites">
			<view class="u-flex u-row-between u-p-30" hover-class="hover-class1" hover-stay-time="50"
				@click="NavigateTos('/pages/mine/problem')">
				<view class="u-flex u-row-left">
					<image src="/static/icon/user_3.png"></image>
					<view class="u-p-l-20">常见问题</view>
				</view>
				<view class="u-flex u-row-right">
					<view class="arror-right"></view>
				</view>
			</view>
			<view class="u-flex u-row-between u-p-30" hover-class="hover-class1" hover-stay-time="50"
				@click="NavigateTos('/pages/mine/about')">
				<view class="u-flex u-row-left">
					<image src="/static/icon/user_5.png"></image>
					<view class="u-p-l-20">关于我们</view>
				</view>
				<view class="u-flex u-row-right">
					<view class="arror-right"></view>
				</view>
			</view>
		</view>
		
		<view  class="padding-lg " style="width: 100%;" v-if="ad_id != '关闭'">
			<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
		</view>

		<view class="" style="height: 180rpx;"></view>

		<view class="cu-modal" :class="showTo?'show':''">
			<view class="cu-dialog radius-xl">
				<view class="cu-bar justify-end">
					<view class="action" @tap="hideTos">
						<text class="cuIcon-close text-black"></text>
					</view>
				</view>
				<view class="padding-xl radius-xl" style="background-color: #ffffff;">

					<view class='text-center'>
						<!-- 头像 -->
						<button class='cu-btn ' open-type="chooseAvatar" @chooseavatar="onChooseAvatar"
							style="background-color: #ffffff;">
							<image class="cu-avatar2 round margin-right-sm box-shadow3"
								style="width: 150rpx;height: 150rpx;" :src="avatarUrl">
							</image>
							<!-- <text class="cuIcon-upload text-orange" style="width: 20rpx;height: 20rpx;"></text> -->
						</button>
					</view>

					<view class="cu-form-group margin-top-xl padding"
						style="height: 100rpx;border-top: 1upx solid #eee;border-bottom: 1upx solid #eee;background-color: #ffffff;">
						<input placeholder="请设置昵称和头像" class="text-center" name="input" id="nickname-input"
							type="nickname" v-model="newNick" maxlength="20"></input>
					</view>


				</view>

				<view class="cu-bar justify-end margin-top-xl">
					<button class="cu-btn bg-orange " style="width: 100%;height: 100rpx;" @click="getUserInfo">
						保 存 修 改
					</button>
				</view>
			</view>
		</view>
	</view>


</template>

<script>
	import logo from '@/static/logo.png'
	let _this;
	var App = require("@/common.js");
	import {
		pathToBase64,
		base64ToPath
	} from 'image-tools'
	export default {
		data() {
			return {
				userInfo: {},
				img: logo,

				userData: [],

				login: false,
				showTo: false,
				avatarUrl: "https://mmbiz.qpic.cn/mmbiz/icTdbqWNOwNRna42FI242Lcia07jQodd2FJGIYQfG0LAJGFxM4FbnQP6yfMxBgJ0F3YRqJCJ1aPAK2dQagdusBZg/0",
				newNick: "",
				is_avatarUrl: false,
				
				ad_id: "关闭",
			}
		},

		mounted() {
			_this = this
			_this.avatarUrl = uni.getStorageSync("avatarUrl") ?uni.getStorageSync("avatarUrl"):'../../static/logo.png'
			App._get('user.index/detail', {}, res => {
				_this.login = true
				_this.userInfo = res.data.userInfo
			});
			
			var setting = uni.getStorageSync("setting")
			if (setting.wxConfig.is_ad == '1') {
				this.ad_id = setting.wxConfig.ad_video
			}
		},
		methods: {
			onChooseAvatar(e) {
				console.log(e.detail.avatarUrl)
				this.avatarUrl = e.detail.avatarUrl
				this.is_avatarUrl = true
			},
			showTos() {
				this.showTo = true
			},
			hideTos() {
				this.showTo = false
			},

			NavigateTos(urls) {
				uni.navigateTo({
					url: urls
				})
			},


			getUserInfo() {
				var _this = this

				uni.createSelectorQuery().in(this) // 注意这里要加上 in(this)  
					.select("#nickname-input")
					.fields({
						properties: ["value"],
					})
					.exec((res) => {
						const nickName = res?. [0]?.value
						console.log('昵称', nickName)
						if (nickName == "" || nickName == null) {
							uni.showToast({
								icon: "none",
								title: "请填写昵称"
							})
							return false;
						}
						if (_this.is_avatarUrl) {

							pathToBase64(_this.avatarUrl).then(data => {
								console.log(data); //data为base64格式的图片
								uni.setStorageSync("avatarUrl", data)
							})
						}

						wx.login({
							success: (loginres) => {

								App._post_form('user/login', {
									code: loginres.code,
									nickName: nickName
								}, res => {
									uni.showToast({
										icon: "none",
										title: "更新成功"
									})
									_this.hideTos()
									App._get('user.index/detail', {}, res => {
										_this.login = true
										_this.userInfo = res.data.userInfo
									});
								}, fail => {

								});

							}
						})


					})

			},


		},
	}
</script>

<style>
	button::after {
		border: none;
	}

	button {
		position: relative;
		display: block;
		margin-left: auto;
		margin-right: auto;
		padding-left: 0px;
		padding-right: 0px;
		box-sizing: border-box;
		font-size: 28rpx;
		text-align: center;
		text-decoration: none;
		line-height: 1;
		line-height: 1.35;
		border-radius: 5px;
		-webkit-tap-highlight-color: transparent;
		overflow: hidden;
		color: #303133;
		background-color: #fff;
		width: 100%;
		height: 100%;
	}
</style>

<style lang="scss">
	@import '@/uview-ui/libs/css/common.scss';


	page {
		background-color: #F7F8FA;
	}

	.whites {
		background-color: white;
	}

	.user {
		.avatar {
			width: 116rpx;
			height: 116rpx;
			border-radius: 116rpx;
		}

		.name {
			font-size: 20px;
			font-weight: 500;
		}
	}

	.integral {
		height: 180rpx;
		margin-left: 40rpx;
		margin-right: 40rpx;
		margin-top: 40rpx;
		border-radius: 20rpx;
		background: linear-gradient(to right, #ffafbd, #ffc3a0);

		image {
			width: 60rpx;
			height: 60rpx;
		}

		.left {
			padding-left: 12rpx;
			font-size: 50rpx;
			color: #775cff;
			font-weight: bold;
		}

		.right {
			margin-top: 80rpx;
			margin-right: 10rpx;
			font-size: 25rpx;
			color: #ffb000;
		}

		.arror {
			width: 15rpx;
			height: 15rpx;
			margin-top: 80rpx;
			border-top: 3rpx solid #ffb000;
			border-right: 3rpx solid #ffb000;
			transform: rotate(45deg);
		}

	}

	.earn {
		display: flex;
		justify-content: space-between;
		margin-top: 40rpx;
		margin-left: 40rpx;
		margin-right: 40rpx;

		image {
			width: 60rpx;
			height: 60rpx;
		}

		.tab {
			box-shadow: 0upx 0upx 25upx rgba(0, 0, 0, 0.1);
			position: relative;
			background-color: #FFFFFF;
			border-radius: 20rpx;
			height: 160rpx;
			width: 330rpx;

			// margin-right: 20rpx;
			.title {
				font-weight: 550;
			}

			.icon {
				width: 80rpx;
				height: 80rpx;
				border-radius: 80rpx;

			}
		}
	}

	.border-box {
		box-shadow: 0upx 0upx 25upx rgba(0, 0, 0, 0.1);
		border-radius: 20rpx;
	}

	.menu {
		image {
			width: 40rpx;
			height: 40rpx;
		}
	}

	.border-bottom {
		border-bottom: 1rpx solid #ffffff;
	}

	.hover-class {
		transform: scale(0.95);
		transition: all 0.2s;
	}

	.hover-class1 {
		background-color: linear-gradient(to right, #ffafbd, #ffc3a0);
	}

	.arror-right {
		width: 15rpx;
		height: 15rpx;
		border-top: 3rpx solid #ffb13c;
		border-right: 3rpx solid #ffb13c;
		transform: rotate(45deg);
	}

	.quit {
		color: #fa6868;
	}

	.loading_page {
		image {
			width: 200rpx;
			height: 200rpx;
		}
	}

	.my-container:before {
		content: ' ';
		display: block;
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		z-index: 1;
		opacity: 1;
		background-image: linear-gradient(to top, rgba(247, 248, 250, 1), rgba(247, 248, 250, 0));
		background-repeat: no-repeat;
		background-position: 50% 0;
		background-size: cover;
	}


	.mainBox {
		height: 30vh;

		.logoImg {
			width: 140rpx;
			height: 140rpx;
			border-radius: 50%;
			position: absolute;
			left: 50%;
			margin-left: -70rpx;
			top: 150rpx;
			display: block;
		}

		.logoName {
			width: 750rpx;
			position: absolute;
			left: 0;
			top: 320rpx;
			text-align: center;
		}
	}
</style>
