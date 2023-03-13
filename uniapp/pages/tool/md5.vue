<template>
	<!-- 这页面直接从插件市场套用的，只修改UI -->
	<view>
		<view class="">
			<cu-custom bgColor="bg-gradual-orange" :isBack="true">
				<block slot="content">修改视频MD5</block>
			</cu-custom>
		</view>
		
		<view class="padding">
			<view class="bg-white radius-xl box-shadow2">
				<view style="width: 100%;height: 400rpx;" class="flex align-center justify-center">
					<text class="cuIcon-cameraaddfill text-orange addClass" @click="addVideo()"
						v-if="xiugaistate == 1"></text>
					<video :src="urldata" v-if="xiugaistate == 2" style="width: 100%;"></video>
				</view>
			</view>
			<view class="bg-white radius-xl box-shadow2 margin-top">
				<view style="width: 100%;height: 290rpx;" class="flex align-center justify-center">
					<text class="text-xl" v-if="xiugaistate == 1">点击上方按钮添加视频修改MD5</text>

					<view class="content_z_c padding text-shadow text-black" v-if="xiugaistate==2">
						<view class="">
							<span class="text-bold">视频时间：</span>{{durationtime}}
						</view>
						<view class="margin-top">
							<span class="text-bold">视频大小：</span>{{videosize}}
						</view>
						<view class="margin-top">
							<span class="text-bold">修改前MD5：</span>{{oldmd5}}
						</view>
						<view class="margin-top">
							<span class="text-bold">修改后MD5：</span>{{newmd5}}
						</view>
					</view>
				</view>
			</view>

			<view class="cu-bar btn-group  margin-top" v-if="xiugaistate==2">
				<button class="cu-btn line-orange shadow lg radius" @click="resetvideo()">清空内容</button>
				<button class="cu-btn bg-gradual-orange shadow lg radius" @click="savevideo()">保存视频</button>
			</view>

			<view class="margin-top text-orange padding-bottom" style="text-align: center;text-decoration:underline;"
				@click="showTips('有效解决视频的唯一性，防重检测，达到原创效果，轻松上热门')">
				修改MD5可以干嘛？
			</view>
		</view>
		<view style="width: 100%;" v-if="ad_id != '关闭'">
			<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
		</view>

	</view>
</template>

<script>
	import util from '../../utils/util.js';
	export default {
		data() {
			return {
				xiugaistate: 1,
				urldata: '',
				oldmd5: "",
				newmd5: "",
				durationtime: "",
				videosize: "",
				ad_id: "关闭",
			}
		},
		onLoad() {
			var setting = uni.getStorageSync("setting")
			if (setting.wxConfig.is_ad == '1') {
				this.ad_id = setting.wxConfig.ad_video
			}
		},
		methods: {
			showTips(msg) {
				uni.showModal({
					content: msg,
					confirmText: '确定'
				})
			},
			// 添加视频
			addVideo() {
				// #ifndef MP-WEIXIN
				return;
				// #endif
				var t = this;
				uni.chooseVideo({
					sourceType: ["album"],
					success: function(res) {
						var n = util.duration(res.duration),
							s = util.kb(res.size),
							o = uni.getFileSystemManager();
						uni.getFileInfo({
								filePath: res.tempFilePath,
								success: function(e) {
									t.oldmd5 = e.digest
									t.durationtime = n
									t.videosize = s
								}
							}),
							o.saveFile({
								tempFilePath: res.tempFilePath,
								filePath: wx.env.USER_DATA_PATH + "/test.mp4",
								success: function(e) {
									console.log(e);
									o.appendFile({
										filePath: wx.env.USER_DATA_PATH + "/test.mp4",
										data: "01",
										success: function(e) {
											uni.getFileInfo({
												filePath: wx.env.USER_DATA_PATH +
													"/test.mp4",
												success: function(e) {
													if (e.errMsg ==
														"getFileInfo:ok") {
														t.newmd5 = e.digest
														t.urldata = wx.env
															.USER_DATA_PATH +
															"/test.mp4"
														t.xiugaistate = 2
													}

												}
											});
										}
									});
								}
							});
					}
				});
			},
			// 清空视频
			resetvideo() {
				// #ifndef MP-WEIXIN
				return;
				// #endif
				var e = this;
				uni.getFileSystemManager().unlink({
					filePath: wx.env.USER_DATA_PATH + "/test.mp4",
					success: function(t) {
						if ("unlink:ok" == t.errMsg) {
							e.xiugaistate = 1
						}

					}
				});
			},
			// 保存视频
			savevideo() {
				// #ifndef MP-WEIXIN
				return;
				// #endif
				var e = this,
					t = wx.getFileSystemManager();
				wx.saveVideoToPhotosAlbum({
					filePath: wx.env.USER_DATA_PATH + "/test.mp4",
					success: function(i) {
						"saveVideoToPhotosAlbum:ok" == i.errMsg && t.unlink({
							filePath: wx.env.USER_DATA_PATH + "/test.mp4",
							success: function(t) {
								if ("unlink:ok" == t.errMsg) {
									e.xiugaistate = 1
									uni.showToast({
										icon: 'none',
										title: '视频保存成功，请到手机相册中查看'
									})
								}
							}
						});
					},
					fail: function(t) {
						if ("saveVideoToPhotosAlbum:fail auth deny" == t.errMsg) {
							wx.showModal({
								title: "保存失败",
								content: "你需要设置授权保存到相册",
								cancelText: "不设置",
								confirmText: "去设置",
								success: function(e) {
									e.confirm ? wx.openSetting({
										success: function(e) {}
									}) : e.cancel;
								}
							})
						}

						if ("saveVideoToPhotosAlbum:fail invalid video" == t.errMsg) {
							uni.showToast({
								icon: 'none',
								title: '视频保存失败，联系客服修复'
							})
						}

					}
				});
			},
		}
	}
</script>

<style>
	page {
		background-color: #F9F9F9;
	}

	.addClass {
		font-size: 150rpx;
	}


	.content_z_c {
		overflow: hidden;
		width: 100%;
		height: 100%;
		font-size: 26rpx;
	}
</style>
