<!-- 帮助反馈页面 -->
<template>
	<view>
		<view class="">
			<cu-custom bgColor="bg-gradual-orange" :isBack="true">
				<block slot="content">常见问题</block>
			</cu-custom>
		</view>
		<view class="bg-list">
			<view v-for="(item,index) in problemBox" :key="index" :title="item.problemTitle" class="list-title" hover-class='none' >
				<view class="text-title">{{item.problemTitle}}</view>
				<view v-for="(problemItem,problemIndex) in item.problemList" :key="problemIndex" class="list-question" 
					hover-class="none" >
					<view class="text-item">{{problemItem.title}}</view>
					<view class="line" v-if="problemIndex!=item.problemList.length-1"></view>
				</view>

			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				problemBox: [{
						problemTitle: '1、无法下载视频？',
						problemList: [{
								title: '请先授权保存到手机相册的权限。',
							},{
								title:'由于手机系统及微信的安全机制，视频大小不能超过10M左右，所以超过这个大小的视频，需要解析成功后，复制无水印链接到浏览器下载'
							}

						]
					},
					{
						problemTitle: '2、为什么下载视频那么慢？',
						problemList: [{
								title: '有些视频比较长，或者多人同时下载，会导致下载速度缓慢，可以点击旁边的【复制链接】按钮到手机浏览器上打开即可使用手机上的网速下载',
							}

						]
					},
					{
						problemTitle: '3、提示域名不合法等无法下载视频？',
						problemList: [{
								title: '可以在解析成功后点击下载按钮旁边的【复制链接】按钮，粘贴到手机浏览器打开即可下载',
							}

						]
					}, {
						problemTitle: '4、为什么视频成功解析了还有水印？',
						problemList: [{
								title: '视频自带的无法去除哦，如果这个视频在该平台APP直接播放是没有水印的，解析后却有水印请联系管理员',
							}
						]
					}
				]
			}
		},
		methods: {
		
		}
	}
</script>

<style>
	page {
		background-color: #F8F8F8;
		height: 100%;
	}



	.bg-box {
		background-color: #F8F8F8;
		position: fixed;
		bottom: 0;
		left: 0;
		right: 0;
	}

	.bg-list {
		margin-bottom: 100rpx;
		background-color: #FFFFFF;
		padding: 30rpx
	}

	.bg-white-box {
		background-color: #FFFFFF;
		margin: 30rpx;
		display: flex;
		flex-direction: row;
		justify-content: center;
		align-items: center;
		padding: 10rpx;
		border-radius: 20rpx;
		color: #303133;
		font-size: 32rpx;
	}

	.vertical-line {
		height: 20rpx;
		background-color: #cecece;
		width: 2rpx;
		margin-left: 30rpx;
		margin-right: 30rpx;
	}

	.line {
		width: 100%;
		height: 1rpx;
		background-color: #F5F5F5;
	}



	.text-title {
		color: #303133;
		font-size: 32rpx;
		font-weight: bold;
	}

	.text-item {
		color: #999999;
		font-size: 28rpx;
		padding: 24rpx;
	}

	.list-title {
		margin-bottom: 30rpx;
	}

	.list-question {
		color: #606266;
		font-size: 28rpx;
	}

	.hover {
		background-color: #eee;
		opacity: 0.6;
	}

	.image {
		width: 40rpx;
		height: 40rpx;
		margin-left: 20rpx;
	}

	.text-feedback {
		padding: 20rpx;
	}

	.text-top {
		margin: 30rpx;
		color: #999999;
		font-size: 28rpx;
	}
</style>
