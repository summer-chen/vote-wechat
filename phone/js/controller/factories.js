myApp.factory('factories', function ($rootScope,$http) {
	var dataList = function(url,data) {
		this.items = [];
		this.busy =false;
		this.url = url;
		this.data = data;
		this.currentPage = 1;
		this.totalPage = 1;
	};
	
	dataList.prototype.init = function() {
		this.items = [];
		this.busy =false;
		this.currentPage = 1;
		this.totalPage = 1;
	};
	
	dataList.prototype.nextPage = function() {
		if(this.busy || this.currentPage > this.totalPage) return;
		this.busy = true;
		this.data.p = this.currentPage;
		$http.post(baseUrl+this.url,this.data)
		.success(function(data) {
			switch(data.serviceResult) {
				case 1:
					var items = data.resultinfo.data;
					this.totalPage = data.resultinfo.pagecount;
					for(var i=0;i<items.length;i++) {
						this.items.push(items[i]);
					}
					console.log(this.items);
					this.busy = false;
					this.currentPage += 1;
					break;
				default:
					$window.location.reload();
					break;
			}
		}.bind(this))
		.error(function(data) {
			//$rootScope.tips("系统繁忙");
		});
	};
	
	return dataList;
 });