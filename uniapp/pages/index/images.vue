<template>
	<view class="div">
		<view class="">
			<cu-custom bgColor="bg-gradual-orange" :isBack="true">
				<block slot="content">图集</block>
			</cu-custom>
		</view>
		
		<view style="width: 100%;" v-if="ad_id != '关闭'">
			<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
		</view>
		<view class="padding">

				<view class="u-demo-block">
					<u-swiper :list="images" effect3d-previous-margin="50" :circular="false" :autoplay="false"
						border-radius="6" bgColor="#ffffff" height="800" :current="index" @change="change"
						:effect3d="true">
					</u-swiper>
				</view>

				<view class="cu-bar btn-group margin-top-xl" style="padding: 0rpx 10rpx;">
					<button class="cu-btn line-orange shadow lg radius" @click="copyText">复制链接</button>
					<button class="cu-btn bg-gradual-orange shadow lg radius" @click="dow">保存封面</button>
				</view>
				<view class="padding flex flex-direction">
					<button class="cu-btn bg-gradual-orange lg" @click="dows">全部下载</button>
				</view>

				<view class="cu-bar bg-white radius-xl margin-top">
					<view class="action sub-title">
						<text class="text-xl text-bold text-orange">文案</text>
						<text class="text-ABC text-orange">content</text>
					</view>
				</view>
				<view class="cu-form-group align-start">
					<textarea v-model="data.title" placeholder="点击下方按钮可以复制文案"
						style="height: 250rpx;background-color: #F9F9FB;border-radius: 15rpx;padding: 20rpx;"></textarea>
				</view>
				<view class="padding flex flex-direction">
					<button class="cu-btn bg-gradual-orange lg" @click="copywa">复制文案</button>
				</view>

		</view>
	</view>
</template>

<script>
	let _this;
	let rewardedVideoAd = null
	import Base64 from 'base-64';
	var App = require("@/common.js");
	export default {
		data() {
			return {
				images: [],
				data: {},
				index: 0,
				code: 403,
				image: 1,

				listBar: [
					'如遇加载失败等，请重新解析！'
				],

				TabCur: 0,
				barList: ['图集', '文案', '其他'],

				ad_id: "关闭",

				ad_excitation: "关闭",
			}
		},
		mounted() {
			this.data = uni.getStorageSync("videoData")
			this.images = this.data.images
			console.log(this.data.images)
			
			_this = this

			uni.setNavigationBarTitle({
				title: this.data.title
			})

			var setting = uni.getStorageSync("setting")
			if (setting.wxConfig.is_ad == '1') {
				_this.ad_id = setting.wxConfig.ad_video
				if (setting.wxConfig.is_download == '1') {
					_this.ad_excitation = setting.wxConfig.ad_excitation
			
					if (wx.createRewardedVideoAd) {
						rewardedVideoAd = wx.createRewardedVideoAd({
							adUnitId: setting.wxConfig.ad_excitation
						})
						rewardedVideoAd.onLoad(() => {
							console.log('onLoad event emit')
						})
						rewardedVideoAd.onError((err) => {
							console.log('onError event emit', err)
						})
						rewardedVideoAd.onClose((res) => {
							// 用户点击了【关闭广告】按钮
							if (res && res.isEnded) {
								// 正常播放结束，可以下发游戏奖励
								console.log('正常播放结束，可以下发游戏奖励')
								_this.adProfit()
							} else {
								// 播放中途退出，不下发游戏奖励
								console.log('不下发游戏奖励')
							}
						})
					}
				}
			}
		},
		watch: {
			code(newVal, oldVal) {
				if (newVal == 200) {
					uni.hideLoading()
					uni.showToast({
						title: "已保存到相册",
						icon: "success",
						duration: 3000
					})
				}
			},
			image(newVal, oldVal) {
				if (newVal - 1 < this.images.length) {
					uni.showLoading({
						title: "下载第" + this.image + "/" + this.images.length + "张"
					})
					var msg = this.images[newVal - 1]
					// msg = encodeURIComponent(msg)
					this.transit(msg, 1)
				} else {
					uni.hideLoading()
					uni.showToast({
						title: "已全部保存",
						icon: "success",
						duration: 3000
					})
				}
			}

		},
		methods: {
			excitation() {
				var times = new Date().getTime();
				if (uni.getStorageSync('times') < times && _this.ad_excitation != '关闭') {
					uni.showModal({
						title: '重要提示',
						content: '因资源紧张，需观看一次广告后可在24小时内不限次数复制/保存视频哦',
						success: function(res) {
							if (res.confirm) {
								console.log('用户点击确定');
								_this.showAd()
							} else if (res.cancel) {
								console.log('用户点击取消');
							}
						}
					});
					return false
				}
				return true
			},
			showAd() {
				rewardedVideoAd.show()
					.catch(() => {
						rewardedVideoAd.load()
							.then(() => rewardedVideoAd.show())
							.catch(err => {
								console.log('激励视频 广告显示失败')
								uni.showToast({
									icon: "none",
									title: '广告显示失败'
								})
							})
					})
			},
			adProfit() {
				var times = new Date().getTime();
				uni.setStorageSync('times', times + 86400000)
			
				uni.showToast({
					icon: "none",
					title: '已解锁24小时内不限次数下载'
				})
			},
			tabSelect(e) {
				this.TabCur = e.currentTarget.dataset.id;
			},
			change(index) {
				this.index = index
			},
			transit(url, i) {
				this.download(uni.getStorageSync("download_image") + encodeURIComponent(url), i)
				
			},
			//图片下载
			download(url, i) {
				uni.downloadFile({
					url: url, //图片地址
					success: (res) => {
						//图片保存到本地
						uni.saveImageToPhotosAlbum({
							filePath: res.tempFilePath,
							success: () => {
								if (i == 0) {
									this.code = 200
								} else {
									this.image = this.image + 1
								}
							},
							fail: function(err) {
								if (err.errMsg === "saveImageToPhotosAlbum:fail:auth denied" || err
									.errMsg === "saveImageToPhotosAlbum:fail auth deny" || err
									.errMsg === "saveImageToPhotosAlbum:fail authorize no response"
								) {
									// 这边微信做过调整，必须要在按钮中触发，因此需要在弹框回调中进行调用
									uni.showModal({
										title: '提示',
										content: '需要您授权保存相册',
										showCancel: false,
										success: modalSuccess => {
											uni.openSetting({
												success(settingdata) {
													console.log("settingdata",
														settingdata)
													if (settingdata
														.authSetting[
															'scope.writePhotosAlbum'
														]) {
														uni.showModal({
															title: '提示',
															content: '获取权限成功,再次点击图片即可保存',
															showCancel: false,
														})
													} else {
														uni.showModal({
															title: '提示',
															content: '获取权限失败，将无法保存到相册哦~',
															showCancel: false,
														})
													}
												},
												fail(failData) {
													console.log("failData",
														failData)
												},
												complete(finishData) {
													console.log("finishData",
														finishData)
												}
											})
										}
									})
								}
							}
						})
					}
				})
			},
			//复制图片链接
			copyText() {
				if (!_this.excitation()) {
					
					return false
				}
				uni.setClipboardData({
					data: this.images[this.index],
					success: function(res) {
						uni.showToast({
							title: '复制成功',
						});
					},
					fail() {
						uni.showToast({
							icon: "error",
							title: '复制失败了'
						});
					}
				});
			},
			//文本复制 公
			copyText2(text) {
				console.log(this.data)
				uni.setClipboardData({
					data: text,
					success: function(res) {
						uni.showToast({
							title: '复制成功',
						});
					},
					fail() {
						uni.showToast({
							icon: "error",
							title: '复制失败了'
						});
					}
				});
			},
			copywa() {
				uni.setClipboardData({
					data: this.data.title,
					success: function(res) {
						uni.showToast({
							title: '复制成功',
						});
					},
					fail() {
						uni.showToast({
							title: '复制失败了',
						});
					}
				});
			},
			dow() {
				if (!_this.excitation()) {
					return false
				}
				this.code = 403
				uni.showLoading({
					title: "拼命下载中"
				})
				var msg = this.images[this.index]
				// msg = encodeURIComponent(msg)
				this.transit(msg, 0)
			},
			dows() {
				if (!_this.excitation()) {
					return false
				}
				this.code = 403
				uni.showLoading({
					title: "下载第" + this.image + "/" + this.images.length + "张"
				})
				var msg = this.images[0]
				// msg = encodeURIComponent(msg)
				this.transit(msg, 1)


			}
		}
	}
</script>

<style>
	page {
		background-color: #FFF;
	}

	.btn-v {
		margin: 23px 0px;
		display: flex;
		justify-content: space-between;
	}

	/* From www.lingdaima.com */
	.btn-a {
		background-image: linear-gradient(45deg, #FF512F 0%, #F09819 51%, #FF512F 100%)
	}

	.btn-a {
		font-size: 14px;
		margin: 0px;
		width: 45%;
		text-align: center;
		transition: 0.5s;
		background-size: 200% auto;
		color: white;
		border-radius: 5px;
		display: block;
		border: 0px;
		box-shadow: 0px 0px 14px -7px #f09819;
	}

	.btn-a:hover {
		background-position: right center;
		/* change the direction of the change here */
		color: #fff;
		text-decoration: none;
	}

	.btn-a:active {
		transform: scale(0.95);
	}

	.btn-b {
		background-image: linear-gradient(45deg, #7a74d9 0%, #8a8ac9 51%, #806fe2 100%)
	}

	.btn-b {
		font-size: 14px;
		margin: 0px;
		width: 45%;
		text-align: center;
		transition: 0.5s;
		background-size: 200% auto;
		color: white;
		border-radius: 5px;
		display: block;
		border: 0px;
		box-shadow: 0px 0px 14px -7px #f09819;
	}

	.btn-b:hover {
		background-position: right center;
		/* change the direction of the change here */
		color: #fff;
		text-decoration: none;
	}

	.btn-b:active {
		transform: scale(0.95);
	}



	/* From www.lingdaima.com */
	button {
		font-size: 14px;
		position: relative;
		display: block;
		text-decoration: none;
		overflow: hidden;
		border-radius: 5px;
		border: none;
	}

	button span {
		position: relative;
		color: #fff;
		font-family: Arial;
		letter-spacing: 8px;
		z-index: 1;
	}

	button .liquid {
		position: absolute;
		top: -80px;
		left: 0;
		width: 100%;
		height: 200px;
		background: #4973ff;
		box-shadow: inset 0 0 50px rgba(0, 0, 0, .5);
		transition: .5s;
	}

	button .liquid::after,
	button .liquid::before {
		content: '';
		width: 200%;
		height: 200%;
		position: absolute;
		top: 0;
		left: 50%;
		transform: translate(-50%, -75%);
		background: #fff;
	}

	button .liquid::before {
		border-radius: 45%;
		background: rgba(20, 20, 20, 1);
		animation: animate 5s linear infinite;
	}

	button .liquid::after {
		border-radius: 40%;
		background: rgba(20, 20, 20, .5);
		animation: animate 10s linear infinite;
	}

	button:hover .liquid {
		top: -120px;
	}

	@keyframes animate {
		0% {
			transform: translate(-50%, -75%) rotate(0deg);
		}

		100% {
			transform: translate(-50%, -75%) rotate(360deg);
		}
	}

	.bottom-tx {
		margin-top: 30px;
		text-align: center;
		font-size: 12px;
	}
</style>
