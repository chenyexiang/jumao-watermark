<template>
	<view>
		<home @ShowNews="ShowNews" v-if="PageCur=='home'" ref="home"></home>
		<mine v-if="PageCur=='mine'" ref="mine"></mine>

		<view class="box">
			<view class="cu-bar tabbar bg-white  shadow shadow-lg  foot">

				<view class="action" @click="NavChange" data-cur="home">
					<view class="action" :class="PageCur=='home' ? 'text-orange text-shadow':'text-gray'">
						<view :class="PageCur=='home' ? 'cuIcon-homefill':'cuIcon-home'"></view>
					</view>
					<view :class="PageCur=='home'?'text-orange':'text-gray'">主页</view>
				</view>


				<view class="action" @click="NavChange" data-cur="mine">
					<view class="action" :class="PageCur=='mine' ? 'text-orange text-shadow':'text-gray'">
						<view :class="PageCur=='mine' ? 'cuIcon-myfill':'cuIcon-my'"></view>
					</view>
					<view :class="PageCur=='mine'?'text-orange':'text-gray'">我的</view>
				</view>

			</view>
		</view>




	</view>
</template>

<script>
	import home from "@/pages/index/index.vue"; //首页
	import mine from "@/pages/mine/mine.vue"; //我的

	var App = require("@/common.js");
	export default {
		components: {
			home,
			mine
		},
		data() {
			return {
				PageCur: 'home',
			};
		},
		// 分享小程序
		onShareAppMessage(res) {
			return {
				title: '超好用的去水印神器',
				path: 'pages/tabbar',
			};
		},
		onLoad(opt) {
			this.wxlogin()

			
			App._get('user/setting', {
			}, res => {
				// getApp().globalData.is_ad =  res.data.wxConfig.is_ad
				
				var download_video = res.data.wxConfig.download_video;
				var download_image = res.data.wxConfig.download_image;
				uni.setStorageSync("download_video",download_video != '' && download_video != null ? download_video :App.download_video_url)
				uni.setStorageSync("download_image",download_image != '' && download_image != null ? download_image :App.download_image_url)
				
				uni.setStorageSync("setting",res.data)
			});

		},
		onShow() {
			uni.hideLoading();
		},
		methods: {
			wxlogin() {
				let _this = this

				// uni.showLoading({
				// 	// mask: true,
				// 	title: "尝试登录中..."
				// })
				wx.login({
					success: (loginres) => {
						console.log(loginres)
						App._post_form('user/login', {
							code: loginres.code
						}, res => {
							uni.setStorageSync("token", res.data.token)
							uni.setStorageSync("user_id", res.data.user_id)
						}, fail => {
							console.log("登录失败")
						});
					}
				})


			},
			ShowNews(e) {
				console.log(e)
				this.PageCur = e;
			},
			NavChange: function(e) {
				this.PageCur = e.currentTarget.dataset.cur;
			},

		}
	}
</script>

<style lang="scss">


</style>
