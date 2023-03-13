<template>
	<view>
		<cu-custom bgColor="bg-gradual-orange" :isBack="true">
			<block slot="content">批量解析</block>
		</cu-custom>

		<view class="padding">
			<view class="bg-white radius-xl box-shadow2">

				<view class="cu-form-group align-start text-xl radius-xl">
					<textarea maxlength="128" placeholder="请复制用户个人主页的分享链接进行批量解析（目前仅支持抖音）" v-model="urls"
						class="bg-gray radius-xl " style="text-align: start;height: 300rpx; padding: 20rpx;"></textarea>
				</view>

			</view>
		</view>
		<view class="cu-bar btn-group padding-xs w100">
			<button class="cu-btn line-orange shadow lg radius" @click="clearUrl">{{urls == null?'粘贴链接':'清空链接'}}</button>
			<button class="cu-btn bg-gradual-orange shadow-blur lg radius" @click="submitUrl">立即解析</button>
		</view>

		<view class="w100  padding" v-if="ad_id != '关闭'">
			<ad :unit-id="ad_id" ad-type="video" ad-theme="white"></ad>
		</view>

		<view class="padding-sm" style="margin-top: -30rpx;">

			<u-waterfall v-model="flowList" ref="uWaterfall">
				<template v-slot:left="{leftList}">
					<view class="demo-warter" v-for="(item, index) in leftList" :key="index" @click="goDetails(item)">
						<u-lazy-load threshold="-450" border-radius="10" :image="item.cover" :index="index">
						</u-lazy-load>
						<view class="demo-title twodanbreak" v-if="item.title != null">
							{{item.title}}
						</view>
					</view>
				</template>
				<template v-slot:right="{rightList}">
					<view class="demo-warter" v-for="(item, index) in rightList" :key="index" @click="goDetails(item)">
						<u-lazy-load threshold="-450" border-radius="10" :image="item.cover" :index="index">
						</u-lazy-load>
						<view class="demo-title twodanbreak" v-if="item.title != null">
							{{item.title}}
						</view>
					</view>
				</template>
			</u-waterfall>
			<u-loadmore bg-color="#F1F1F1" :status="loadStatus" @loadmore="addRandomData" v-if="flowList.length > 0">
			</u-loadmore>
		</view>
	</view>
</template>

<script>
	var App = require("@/common.js");
	export default {
		data() {
			return {
				urls: null,
				ad_id: "关闭",


				// 瀑布流
				loadStatus: 'loadmore',
				flowList: [],


				newUrl: "",
				times: -1,
				isBottom: false
			}
		},
		onLoad(opt) {
			var setting = uni.getStorageSync("setting")
			if (setting.wxConfig.is_ad == '1') {
				if (uni.getStorageSync("kami_time") != 1) {
					this.ad_id = setting.wxConfig.ad_video
				}
			}


			// this.addRandomData();
		},
		onReachBottom() {
			console.log('上拉触底函数开启')
			if (this.times != -1 && this.isBottom) {
				this.isBottom = false
				this.loadStatus = 'loading'
				this.addRandomData()
			}
		},
		methods: {
			addRandomData() {

				var _this = this
				if (_this.times != -1) {
					App._get('apis/batch', {
						url: _this.newUrl,
						times: _this.times
					}, res => {

						_this.times = res.data.times
						for (let i = 0; i < res.data.list.length; i++) {
							_this.flowList.push(res.data.list[i]);
						}
						if (res.data.times == -1) {
							_this.loadStatus = 'nomore'
							_this.isBottom = false
						} else {
							_this.loadStatus = 'loadmore'
							_this.isBottom = true
						}
					});
				}
			},
			goDetails(item) {
				uni.setStorageSync("videoData", item)
				uni.navigateTo({
					url: '/pages/index/video'
				})
			},
			clearUrl() {
				if(this.urls == null){
					console.log("zhang")
					let _this = this
					uni.getClipboardData({
						success: function(res) {
							console.log(res)
							_this.urls = res.data
						}
					});
				}else{
						console.log("2222")
					this.urls = null
					this.$refs.uWaterfall.clear();
					this.flowList = []
					this.newUrl = ""
					this.times = -1
				}
				
			},
			submitUrl() {
				var getUrl = this.urls
				if (getUrl.search('v.douyin.com') != -1) {
					var getUrl = this.urls.match(/(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g)[0]
					if (getUrl == null) {
						uni.showToast({
							title: '糟糕！您填写的内容找不到解析地址，无法解析！',
							icon: 'none',
							duration: 2000
						});
						this.urls = ''
						return;
					}
					// uni.showLoading({
					// 	title: '解析中...',
					// 	mask: true
					// });

					var _this = this
					App._get('apis/batch', {
						url: getUrl
					}, res => {
						_this.newUrl = getUrl
						_this.times = res.data.times
						setTimeout(function() {
							uni.hideLoading();
						}, 100);
						_this.flowList = res.data.list;
						if (res.data.times == -1) {
							_this.loadStatus = 'nomore'
							_this.isBottom = false
						} else {
							_this.loadStatus = 'loadmore'
							_this.isBottom = true
						}
						uni.showToast({
							title: "解析成功",
							icon: "success"
						});
					});
				} else {
					uni.showToast({
						title: '请填写抖音用户个人主页分享链接',
						icon: "none"
					})
				}
			},


		}
	}
</script>


<style lang="scss" scoped>
	.demo-warter {
		border-radius: 8px;
		margin: 5px;
		background-color: #ffffff;
		padding: 10px;
		box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.07);
		position: relative;
		margin-top: 20rpx;
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
</style>
