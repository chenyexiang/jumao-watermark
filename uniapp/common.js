module.exports = {

	api_root: 'https://填写域名/index.php?s=/api/', // api地址

	// 图片下载
	download_image_url: 'https://填写域名/image.php?url=',

	// 视频下载
	download_video_url: 'https://填写域名/video.php?url=',
	
	// 这里填写后端对应的小程序id
	uniacid: '10001',

	/**
	 * 全局变量
	 */
	globalData: {
		user_id: null,
	},
	/**
	 * 生命周期函数--监听小程序初始化
	 */
	onLaunch(e) {
		console.log('监听小程序初始化', e);
	},

	/**
	 * 获取小程序ID
	 */
	getWxappId() {
		return this.uniacid || 10001;
	},

	/**
	 * 授权登录
	 */
	wxLogin() {
		let _this = this
		_this._get('user/detail', {}, result => {})
	},

	/**
	 * 当小程序启动，或从后台进入前台显示，会触发 onShow
	 */
	onShow(options) {
		console.log(options)
	},
	/**
	 * 执行用户登录
	 */
	doLogin(delta) {
		// 保存当前页面
		let pages = getCurrentPages();
		console.log('dalogin')
		if (pages.length) {
			let currentPage = pages[pages.length - 1];
			if (currentPage.route != 'pages/login/login') {
				// 跳转授权页面
				console.log('jinlai')
				uni.navigateTo({
					url: "/pages/login/login?delta=" + (delta || 1)
				});
			}
		}
	},

	isLogin() {
		if (!uni.getStorageSync('token') || uni.getStorageSync('token') == '') {
			this.navigationTo('pages/login/login')
		}
	},
	/**
	 * 当前用户id  
	 */
	getUserId() {
		return uni.getStorageSync('user_id');
	},
	/**
	 * 显示成功提示框
	 */
	showSuccess(msg, callback, duration = 1000) {
		uni.showModal({
			title: msg,
			icon: 'success',
			mask: true,
			showCancel: false,
			duration: duration,
			success() {
				callback && (setTimeout(function() {
					callback();
				}, duration));
			}
		});
	},
	/**
	 * 显示失败提示框
	 */
	showError(msg, callback) {
		uni.showModal({
			title: '友情提示',
			icon: 'none',
			content: msg,
			showCancel: false,
			success(res) {
				// callback && (setTimeout(function() {
				//   callback();
				// }, 1500));
				callback && callback();
			}
		});
	},
	/**
	 * get请求
	 */
	_get(url, data, success, fail, complete, check_login) {
		uni.showNavigationBarLoading();
		let _this = this;
		// 构造请求参数
		data = data || {};
		data.wxapp_id = _this.getWxappId();

		// 构造get请求
		let request = function() {
			data.token = uni.getStorageSync('token');
			uni.request({
				url: _this.api_root + url,
				header: {
					'content-type': 'application/json'
				},
				data: data,
				success(res) {
					console.log(res)
					if (res.statusCode !== 200 || typeof res.data !== 'object') {
						return false;
					}
					if (res.data.code === -1) {
						// 登录态失效, 重新登录
						uni.hideNavigationBarLoading();
						_this.showError(res.data.msg, function() {
							fail && fail(res);
						});
					} else if (res.data.code === 0) {
						_this.showError(res.data.msg, function() {
							fail && fail(res);
						});
						return false;
					} else {
						success && success(res.data);
					}
				},
				fail(res) {
					console.log(res)
					_this.showError('网络连接失败', function() {
						fail && fail(res);
					});
				},
				complete(res) {
					uni.hideNavigationBarLoading();
					complete && complete(res);
				},
			});
		};
		// 判断是否需要验证登录
		check_login ? this.doLogin(request) : request();
	},
	/**
	 * post提交
	 */
	_post_form(url, data, success, fail, complete) {
		let _this = this;
		data.wxapp_id = _this.getWxappId();
		data.token = uni.getStorageSync('token');


		console.log('_post_form请求：' + url)
		console.log(_this.api_root + url + '/token/' + data.token + '/wxapp_id/' + data.wxapp_id)
		uni.request({
			url: _this.api_root + url,
			header: {
				'content-type': 'application/x-www-form-urlencoded',
			},
			method: 'POST',
			data: data,
			success(res) {
				console.log(res)
				if (res.statusCode !== 200 || typeof res.data !== 'object') {
					// _this.showError('(_post)网络请求出错');
					return false;
				}
				if (res.data.code === -1) {
					// 登录态失效, 重新登录
					_this.showError(res.data.msg, function() {
						fail && fail(res);
					});
					return false;
				} else if (res.data.code === 0) {
					_this.showError(res.data.msg, function() {
						fail && fail(res);
					});
					return false;
				}
				success && success(res.data);
			},
			fail(res) {
				console.log(res);
				_this.showError('网络连接失败', function() {
					// fail && fail(res);
				});
			},
			complete(res) {
				uni.hideLoading();
				// complete && complete(res);
			}
		});
	},





}
