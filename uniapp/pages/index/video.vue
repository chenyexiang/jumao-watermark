<template>
	<view class="div">
		<view class="">
			<cu-custom bgColor="bg-gradual-orange" :isBack="true">
				<block slot="content">{{data.title}}</block>
			</cu-custom>
		</view>



		<view style="width: 100%;" v-if="ad_id != '关闭'">
			<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
		</view>

		<view class="padding">

			<view class="bg-white radius-xl shadow bg-white">
				<view class="cu-bar bg-white radius-xl">
					<view class="action sub-title">
						<text class="text-xl text-bold text-orange">视频</text>
						<text class="text-ABC text-orange">video</text>
					</view>
				</view>
				<view class="padding-xl" style="margin-top: -20rpx;">
					<video :src="data.video" class="video" @error="videoErrorCallback"></video>
				</view>
				<view class="cu-progress round sm striped active" style="z-index: 999;"
					:style="progress > 0?'':'background-color:#F9F9FB'" v-if="progress > 0">
					<view class="bg-orange" :style="[{ width:progress > 0?progress + '%':''}]"></view>
				</view>
				<view class="cu-bar btn-group padding">
					<button class="cu-btn line-orange shadow lg radius" @click="copyText(data.video)">复制链接</button>
					<button class="cu-btn bg-gradual-orange shadow lg radius"
						@click="uploadVideo(data.video)">保存视频</button>
				</view>

				<view class="margin-top text-orange padding-bottom"
					style="text-align: center;text-decoration:underline;"
					@click="showTips('点击“复制链接”，到浏览器打开即可下载（推荐使用QQ浏览器打开）')">
					下载失败？点我查看解决方案
				</view>
			</view>

			<view class="bg-white radius-xl  shadow bg-white margin-top">
				<view class="cu-bar bg-white radius-xl">
					<view class="action sub-title">
						<text class="text-xl text-bold text-orange">封面</text>
						<text class="text-ABC text-orange">cover</text>
					</view>
				</view>

				<image :src="data.cover" class="padding-xl" mode="widthFix" style="width: 100%;border-radius: 15rpx;">
				</image>

				<view class="cu-bar btn-group  padding">
					<button class="cu-btn line-orange shadow lg radius" @click="copyText(data.cover)">复制链接</button>
					<button class="cu-btn bg-gradual-orange shadow lg radius" @click="uploadCover()">保存封面</button>
				</view>
			</view>

			<view class="bg-white radius-xl  shadow bg-white margin-top">
				<view class="cu-bar bg-white radius-xl">
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
					<button class="cu-btn bg-gradual-orange lg" @click="copyText(data.title)">复制文案</button>
				</view>
			</view>




		</view>
	</view>
</template>

<script>
	let rewardedVideoAd = null
	import Base64 from 'base-64';
	var App = require("@/common.js");
	export default {
		data() {
			return {
				data: [],
				progress: 0,
				title: '视频封面:',
				value: '',
				none: 'domhide',
				show: false,
				list: [{
					type: 'success',
					title: '成功',
					message: "获取成功！正在下载！",
					iconUrl: 'https://cdn.uviewui.com/uview/demo/toast/success.png'
				}],



				ad_id: "关闭",

				ad_excitation: "关闭",

				isDownload: false,





			}
		},
		mounted() {


			this.data = uni.getStorageSync("videoData")
			console.log(this.data)

			let _this = this
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
		onLoad(value) {},
		methods: {
			excitation() {
				var times = new Date().getTime();
				let _this = this
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

			showTips(msg) {
				uni.showModal({
					content: msg,
					confirmText: '确定'
				})
			},
			tabSelect(e) {
				this.TabCur = e.currentTarget.dataset.id;
			},
			transit(url) {
				this.Video(uni.getStorageSync("download_video") + url)
			},
			// 下载视频
			Video(url) {
				let _this = this
				this.none = "domshow"
				// 1 将远程文件下载到小程序的内存中
				const downloadTask = uni.downloadFile({
					url: url.replace('http://', 'https://'),
					success: (res) => {
						// 2 成功下载后而且状态码为200时将视频保存到本地系统
						if (res.statusCode === 200) {
							uni.saveVideoToPhotosAlbum({
								filePath: res.tempFilePath,
								success() {
									uni.showToast({
										title: "下载成功",
										icon: "success",
										duration: 2000
									});
								}
							})
						} else {
							uni.showToast({
								title: "资源格式错误，请联系管理员",
								icon: "error",
								duration: 4000
							});
						}
					},
					fail: (err) => {
						if (err.errMsg.includes("fail url not in domain list")) {
							console.log("记录域名", url.replace(/^https?:\/\/(.*?)(:\d+)?\/.*$/, '$1'))
							uni.showToast({
								title: "正在使用服务器中转下载",
								icon: "none",
							});
							try {
								App._post_form('wxapp/addUrl', {
									url: url.replace(/^https?:\/\/(.*?)(:\d+)?\/.*$/, '$1')
								}, res => {

								}, fail => {});
							} catch (e) {
								//TODO handle the exception
							}
							_this.zVideo(uni.getStorageSync("download_video") + url)
						} else {
							uni.showModal({
								title: '提示',
								content: '下载失败了',
								showCancel: false,
							})
						}
						// 下载失败提醒
						uni.hideLoading();
					}
				})
				downloadTask.onProgressUpdate(res => {
					this.progress = res.progress
				});
			},
			zVideo(url) {
				let _this = this
				this.none = "domshow"
				// 1 将远程文件下载到小程序的内存中
				const downloadTask = uni.downloadFile({
					url: url,
					success: (res) => {
						// 2 成功下载后而且状态码为200时将视频保存到本地系统
						if (res.statusCode === 200) {
							uni.saveVideoToPhotosAlbum({
								filePath: res.tempFilePath,
								success() {
									uni.showToast({
										title: "下载成功",
										icon: "success",
										duration: 2000
									});
								}
							})
						} else {
							uni.showToast({
								title: "资源格式错误，请联系管理员",
								icon: "error",
								duration: 4000
							});
						}
					},
					fail: (err) => {
						uni.showModal({
							title: '提示',
							content: '下载失败了',
							showCancel: false,
						})
						// 下载失败提醒
						uni.hideLoading();
					}
				})
				downloadTask.onProgressUpdate(res => {
					this.progress = res.progress
				});
			},
			videoErrorCallback: function(e) {
				uni.showModal({
					content: e.target.errMsg,
					showCancel: false
				})
			},
			copyText(text) {

				if (!this.excitation()) {
					return false
				}
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
			uploadVideo(url) {
				if (!this.excitation()) {
					return false
				}
				// 提醒用户下载中
				uni.showLoading({
					title: "正在获取资源.."
				})

				this.Video(url)
			},



			uploadCover() {
				uni.showLoading({
					title: "拼命下载中"
				})
				let msg = this.data.cover

				this.download(uni.getStorageSync("download_image") + encodeURIComponent(msg))

			},
			download(url) {
				uni.downloadFile({
					url: url, //图片地址
					success: (res) => {
						//图片保存到本地
						uni.saveImageToPhotosAlbum({
							filePath: res.tempFilePath,
							success: () => {
								uni.hideLoading()
								uni.showToast({
									title: "已保存到相册",
									icon: "success",
									duration: 3000
								})
							},
							fail: function(err) {
								uni.hideLoading();
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
			}
		}
	}
</script>

<style>
	page {
		background-color: #F9F9FB;
	}
</style>

<style lang="scss">
	.u-page {
		padding: 0;
	}

	.u-cell-icon {
		width: 36rpx;
		height: 36rpx;
		margin-right: 8rpx;
	}

	.u-cell-group__title__text {
		font-weight: bold;
	}

	.video {
		width: 100%;
		border-radius: 8px;
	}

	.save-sp {
		background-image: linear-gradient(45deg, #f28888 0%, #df5f5f 51%, #f19e9e)
	}

	.btn {
		margin: 0px;
		width: 45%;
		font-size: 14px;
		text-align: center;
		text-transform: uppercase;
		transition: 0.5s;
		background-size: 200% auto;
		color: white;
		border-radius: 6px;
		display: block;
		border: 0px;
	}

	.btn:hover {
		background-position: right center;
		/* change the direction of the change here */
		color: #fff;
		text-decoration: none;
	}

	.btn:active {
		transform: scale(0.95);
	}


	.btn-sp {
		background: linear-gradient(122deg, rgba(193, 85, 238, 1) 0%, rgba(209, 160, 241, 1) 40%, rgba(222, 178, 236, 1) 100%);
	}

	.save-co {
		background: linear-gradient(90deg, rgba(24, 112, 172, 1) 0%, rgba(31, 200, 209, 1) 67%, rgba(0, 212, 255, 1) 100%)
	}

	.cover-c {
		width: 100%;
		height: 200px;
		margin-top: 20px;
		border-radius: 4px;
	}

	.bottom-tx {
		margin-top: 30px;
		text-align: center;
		font-size: 12px;
	}

	.domhide {
		display: none;
	}

	.domshow {
		display: block;
	}
</style>
