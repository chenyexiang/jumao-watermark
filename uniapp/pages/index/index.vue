<template>
	<view>
		<cu-custom bgColor="bg-gradual-orange" :isBack="false">
			<block slot="content">橘猫去水印</block>
		</cu-custom>
		<view class="body">


			<!-- <u-notice-bar :list="listBar" bgColor="rgba(255, 255, 255, 0.1)" color="#FF3333"></u-notice-bar> -->

			<view class="padding-sm ">
				<swiper class="screen-swiper square-dot radius-xl" :indicator-dots="true" :circular="false"
					:autoplay="true" interval="5000" duration="1000">
					<swiper-item v-for="(item,index) in swiperList" :key="index">
						<image :src="item" mode="aspectFill" class="radius-xl"></image>
					</swiper-item>
				</swiper>
			</view>




			<u-notice-bar mode="horizontal" type="error" :list="listBar"></u-notice-bar>

			<view class="cu-bar bg-white" style="margin-top: 20rpx;">
				<view class="action sub-title">
					<text class="text-xl text-bold text-orange">快速去水印</text>
					<text class="text-ABC text-orange">speedy</text>
				</view>
				<view class="action" @click="closeUrl"><text class="text-lg text-grey text-shadow">清空</text></view>
			</view>




			<view class="padding" style="margin-top: -20rpx;">

				<view class="view-test box-shadow2">
					<textarea v-model="video_url" placeholder="请粘贴需要提取的视频/图集链接" class="padding"
						style="width: 100%; height: 120px; border: 2rpx;"></textarea>
				</view>
			</view>

			<view class="padding-xs">
				<view class="cu-bar btn-group margin-top-xs">
					<button class="cu-btn line-orange shadow lg  " @click="zhantie()">粘贴链接</button>
					<button class="cu-btn bg-gradual-orange shadow lg " @click="getVideo()">立即解析</button>
				</view>
			</view>



			<view class="cu-bar bg-white" style="margin-top: 20rpx;">
				<view class="action sub-title">
					<text class="text-xl text-bold text-orange">更多功能</text>
					<text class="text-ABC text-orange">other</text>
				</view>
			</view>



			<view class="skill-sequence-panel-content-wrapper ">
				<!--左边虚化-->
				<view class="hide-content-box hide-content-box-left"></view>
				<!--右边虚化-->
				<view class="hide-content-box hide-content-box-right"></view>
				<scroll-view scroll-x="true" class="kite-classify-scroll">
					<view class="kite-classify-cell box-shadow2" v-for="(item, index) in curriculum" :key="index"
						@click="goView(item.url)">
						<view :class="'nav-li bg-index' + (index + 1)" style="height: 100%;">
							<view class="nav-name2 text-shadow text-white">{{ item.name }}</view>
							<view class="nav-name3 text-shadow">{{ item.content }}</view>
						</view>
					</view>
				</scroll-view>
			</view>



			<view class="padding-sm" style="width: 100%;" v-if="ad_id != '无'">
				<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
			</view>




			<view style="width: 100%;height: 150rpx;">

			</view>
		</view>

	</view>
</template>

<script>
	var App = require("@/common.js");
	export default {

		data() {
			return {
				video_url: '',

				listBar: [
					'欢迎使用橘猫去水印，小程序持续更新中...'
				],

				swiperList: ['https://s1.ax1x.com/2022/08/17/vD37YF.png'],

				recordsData: [],




				ad_id: '无',



				curriculum: [{
						name: '修改MD5',
						content: '上热门必备...',
						url: '/pages/tool/md5'
					},
					{
						name: '批量解析',
						content: '主页视频解析...',
						url: '/pages/tool/batch'
					},
					{
						name: '待开发',
						content: '更多功能待开发',
						url: null
					}
				],
			}
		},


		mounted() {
			let _this = this
			if (!uni.getStorageSync("setting")) {
				App._get('user/setting', {}, res => {
					var download_video = res.data.wxConfig.download_video;
					var download_image = res.data.wxConfig.download_image;
					uni.setStorageSync("download_video",download_video != '' && download_video != null ? download_video :App.download_video_url)
					uni.setStorageSync("download_image",download_image != '' && download_image != null ? download_image :App.download_image_url)
					
					var setting = res.data
					var newList = []
					for (var i = 0; i < setting.bannle.length; i++) {
						newList.push(setting.bannle[i].title)
					}
					_this.swiperList = newList
					_this.listBar[0] = setting.wxConfig.notice

					if (setting.wxConfig.is_ad == '1') {
						_this.ad_id = setting.wxConfig.ad_video
					}
					
					uni.setStorageSync("setting", res.data)
				});
			} else {
				var setting = uni.getStorageSync("setting")
				
				var download_video = setting.wxConfig.download_video;
				var download_image = setting.wxConfig.download_image;
				uni.setStorageSync("download_video",download_video != '' && download_video != null ? download_video :App.download_video_url)
				uni.setStorageSync("download_image",download_image != '' && download_image != null ? download_image :App.download_image_url)
				
				var newList = []
				for (var i = 0; i < setting.bannle.length; i++) {
					newList.push(setting.bannle[i].title)
				}
				_this.swiperList = newList
				_this.listBar[0] = setting.wxConfig.notice

				if (setting.wxConfig.is_ad == '1') {
					_this.ad_id = setting.wxConfig.ad_video
				}
			}



		},
		methods: {




			getVideo() {
				let _this = this
				if (this.video_url == '' || this.video_url == null) {
					uni.showToast({
						title: '请填写内容后解析哦！',
						icon: 'none',
						duration: 2000
					});
				} else {
					// 提取地址链接
					var getUrl = this.video_url.match(/(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g)
					if (getUrl == null) {
						uni.showToast({
							title: '糟糕！您填写的内容找不到解析地址，无法解析！',
							icon: 'none',
							duration: 2000
						});
						this.video_url = ''
						return;
					}
					uni.showLoading({
						title: '解析中...',
						mask: true
					});


					App._post_form('video/getInfo', {
						url: getUrl
					}, res => {
						setTimeout(function() {
							uni.hideLoading();
						}, 100);
						uni.showToast({
							title: "解析成功",
							icon: "success"
						});


						console.log(res)

						// _this.data.y_url = getUrl
						_this.video_url = ''


						uni.setStorage({
							key: "videoData",
							data: res.data,
							success() {
								if (res.data.hasOwnProperty('images')) {

									var recordsData2 = {
										title: res.data.title,
										cover: res.data.cover,
										video: null,
										images: res.data.images,
										type: 0,
										y_url: getUrl
									}
									_this.recordsData.unshift(recordsData2)
									if (_this.recordsData.length >= 16) {
										_this.recordsData.pop()
									}
									uni.setStorageSync("recordsData", _this.recordsData)
									uni.navigateTo({
										url: '/pages/index/images'
									})
								} else {

									var recordsData2 = {
										title: res.data.title,
										cover: res.data.cover,
										video: res.data.video,
										images: null,
										type: 1,
										y_url: getUrl
									}
									_this.recordsData.unshift(recordsData2)
									if (_this.recordsData.length >= 16) {
										_this.recordsData.pop()
									}
									uni.setStorageSync("recordsData", _this
										.recordsData)
									uni.navigateTo({
										url: '/pages/index/video'
									})
								}
							}
						})

					}, fail => {
						uni.showToast({
							icon: "error",
							title: "解析失败"
						})
					});


				}

			},
			closeUrl() {
				let _this = this

				uni.showModal({
					title: '提示',
					content: '确定要清空当前输入框吗？',
					cancelText: '取消',
					confirmText: '确定',
					success: res => {
						if (res.confirm) {
							_this.video_url = ""
						} else {

						}
					}
				})
			},
			goView(url) {
				if (url != null) {
					uni.navigateTo({
						url: url
					})
				} else {
					uni.showToast({
						title: '糟糕！作者居然还没开发完....',
						icon: "none"
					})
					this.show = !this.show
				}

			},
			zhantie() {
				let _this = this
				uni.getClipboardData({
					success: function(res) {
						console.log();
						_this.video_url = res.data
					}
				});
			},



		},


	}
</script>

<style>
	page {
		background-color: #fff;
	}

	.bottom-tx {
		margin-top: 20rpx;
		text-align: center;
		font-size: 12px;
	}

	.bend {
		width: 100%;
	}

	.body {
		position: relative;
		/* padding: 10rpx; */
		/* margin-top: -37rpx; */
		border-top-left-radius: 50rpx;
		border-top-right-radius: 50rpx;
		background-color: #ffffff;
		/* opacity: 0.7; */
		/* width: 100vw; */
	}

	.body_be {
		padding: 10rpx 0;
	}

	.demo-layout-body {
		width: calc(100% / 3);
		float: left;
	}

	.lin-body {
		padding: 5rpx 10rpx;
	}

	.lin-body image {
		/* text-align: center; */
		/* padding: 5rpx; */
		width: 100%;
		height: 450rpx;
		border-radius: 15rpx;
	}
</style>



<style lang="scss" scoped>
	.view-test {
		border-radius: 25rpx;
		background-color: #F5F5F5;
	}

	.demo-warter {
		border-radius: 8px;
		margin: 5px;
		background-color: #ffffff;
		padding: 10px;
		box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.07);
		position: relative;
		margin-top: 30rpx;
	}

	.u-close {
		position: absolute;
		top: 32rpx;
		right: 32rpx;
	}

	.demo-image {
		width: 100%;
		border-radius: 4px;
	}

	.demo-title {
		font-size: 26rpx;
		margin-top: 5px;
		color: $u-main-color;
	}

	.demo-tag {
		display: flex;
		margin-top: 5px;
	}

	.demo-tag-owner {
		background-color: $u-type-error;
		color: #FFFFFF;
		display: flex;
		align-items: center;
		padding: 4rpx 14rpx;
		border-radius: 50rpx;
		font-size: 20rpx;
		line-height: 1;
	}

	.demo-tag-text {
		border: 1px solid $u-type-primary;
		color: $u-type-primary;
		margin-left: 10px;
		border-radius: 50rpx;
		line-height: 1;
		padding: 4rpx 14rpx;
		display: flex;
		align-items: center;
		border-radius: 50rpx;
		font-size: 20rpx;
	}

	.demo-price {
		font-size: 30rpx;
		color: $u-type-error;
		margin-top: 5px;
	}

	.demo-shop {
		font-size: 22rpx;
		color: $u-tips-color;
		margin-top: 10px;
	}


	.my-shadow {
		box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.07);
		// box-shadow: 0px 5px 5px 0px #EDEDED;
		border-radius: 20rpx;
	}

	/* 图标容器7 start */
	.icon7 {
		width: 100rpx;
		height: 100rpx;
	}
</style>


<style lang="scss" scoped>
	/*scroll-view外层*/
	.skill-sequence-panel-content-wrapper {
		position: relative;
		white-space: nowrap;
		padding: 10rpx 0 10rpx 10rpx;
	}

	/*左右渐变遮罩*/
	.hide-content-box {
		position: absolute;
		top: 0;
		height: 100%;
		width: 10px;
		z-index: 2;
	}

	.hide-content-box-left {
		left: 0;
		background-image: linear-gradient(to left, rgba(255, 255, 255, 0), #f3f3f3 60%);
	}

	.hide-content-box-right {
		right: 0;
		background-image: linear-gradient(to right, rgba(255, 255, 255, 0), #f3f3f3 60%);
	}

	.kite-classify-scroll {
		width: 100%;
		// height: 180rpx;
		overflow: hidden;
		white-space: nowrap;
	}

	.kite-classify-cell {
		display: inline-block;
		width: 266rpx;
		height: 200rpx;
		margin-right: 20rpx;
		// background-color: #ffffff;
		border-radius: 10rpx;
		overflow: hidden;
	}

	.nav-li {
		padding: 40rpx 30rpx;
		width: 100%;
		background-image: url(https://s1.ax1x.com/2020/06/27/NyU04x.png);
		background-size: cover;
		background-position: center;
		position: relative;
		z-index: 1;
	}

	.nav-name {
		font-size: 28upx;
		text-transform: Capitalize;
		margin-top: 20upx;
		position: relative;
	}

	.nav-name::before {
		content: '';
		position: absolute;
		display: block;
		width: 40rpx;
		height: 6rpx;
		background: #fff;
		bottom: 0;
		right: 0;
		opacity: 0.5;
	}

	.nav-name::after {
		content: '';
		position: absolute;
		display: block;
		width: 100rpx;
		height: 1px;
		background: #fff;
		bottom: 0;
		right: 40rpx;
		opacity: 0.3;
	}

	.nav-content {
		width: 100%;
		padding: 15rpx;
		display: inline-block;
		overflow-wrap: break-word;
		white-space: normal;
	}

	.nav-btn {
		width: 200rpx;
		height: 60rpx;
		margin: 8rpx auto;
		text-align: center;
		line-height: 60rpx;
		border-radius: 10rpx;
	}

	.bg-index1 {
		background-color: #ff4f94;
		color: #fff;
	}

	.bg-index2 {
		background-color: #f49a02;
		color: #fff;
	}

	.bg-index3 {
		background-color: #DE83F3;
		color: #fff;
	}

	.bg-index4 {
		background-color: #954ff6;
		color: #fff;
	}

	.bg-index5 {
		background-color: #19cf8a;
		color: #fff;
	}

	.bg-index6 {
		background-color: #7fd02b;
		color: #fff;
	}

	.item-name {
		margin-bottom: 15rpx;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 1;
		overflow: hidden;
	}

	.nav-name2 {
		font-size: 36rpx;
		font-weight: bold;
	}

	.nav-name3 {
		margin-top: 30rpx;
		font-size: 28rpx;
	}
</style>
