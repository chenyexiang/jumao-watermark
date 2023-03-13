<template>
	<view>
		<view class="">
			<cu-custom bgColor="bg-gradual-orange" :isBack="true">
				<!-- <block slot="backText">返回</block> -->
				<block slot="content">关于</block>
			</cu-custom>
		</view>
			
		<view class="userHome">
			<view  style="width: 100%;text-align: center;">
				<text class="text-gray text-xl text-center">关于作者</text>
			</view>
			
			<view class="margin-top-lg">
				<text>Hi!  欢迎使用橘猫去水印！</text>
			</view>
			
			<view class="margin-top">
				<text><text style="margin-left: 40rpx;"></text>该小程序是我练手的一个小程序，不过也多次套用了别人的代码，哈哈哈。不过这个小程序永久免费使用就对了。</text>
			</view>
		</view>
	</view>
</template>

<script>
	export default {

		data() {
			return {

			}
		},
		onLoad() {},

		methods: {

		}
	}
</script>

<style>
	page {
		background-color: #F1F1F1;
	}
	
	.userHome{
		background-color: #FFFFFF;
		margin: 50rpx;
		padding: 50rpx;
		border-radius: 10rpx;
	}
	
	text{
		color: #7C7C7C;
	}
</style>
