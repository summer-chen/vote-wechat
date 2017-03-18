/**
 * Created by ASUS1 on 2017/3/3.
 */
myApp.filter("picurlFormat",function(){
    return function(input){
        var out = baseUrl + "Public/Uploads/";
        out = out + input;
        return out;
    }
})
.filter("presentFormat",function(){
    return function (input) {
        if(input.pid == 1) {
            var vote = "投了"+input.count+"票~";
            return vote;
        }else if(input.pid == 2){
            var vote = "转发了"+input.count+"次~";
            return vote;
        }else if(input.pid == 3){
            var crown = "送了"+input.count+"个皇冠~";
            return crown;
        }else if(input.pid == 4){
            var kiss = "送了"+input.count+"个香吻~"
            return kiss;
        }else if(input.pid == 5){
            var flower = "送了"+input.count+"朵花花~"
            return flower;
        }
    }
})

.filter("zero",function () {
    return function (input) {
        if(input == null)
            return 0;
        else
            return input;
    }
});

