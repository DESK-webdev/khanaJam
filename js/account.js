// var i=0;
// while(i<document.getElementsByTagName("a").length){
//     document.getElementsByTagName("a")[i].href="#";
//     i++;
// }

// Create the ajax request object.
function makeRequest(method, url) {
    var request = new XMLHttpRequest(); 
    if ("withCredentials" in request) {
        request.open(method, url, true);
    } 
    else if (typeof XDomainRequest != "undefined") {
        request = new XDomainRequest();
        request.open(method, url);
    } else {
        request = null;
    }
    return request;
}

function callback_ajax(callback_for="",args=""){
    var data=JSON.parse(args);
    // console.log(data.data);
    var match="";
    var i=0;
    while(i<data.self_count){
        match=data.data[i];

        if(match.name=="correct"){
            if(!match.boolean){
                ///on incorrect crediantials
            }
        }

        if(match.name=="logged"){
            if(match.boolean){
                document.getElementById("a_login").innerHTML="logout";
            }
            else{
                //on not logged in
            }
        }
        
        if(match.name=="remember"){
            ///on rememering browser
        }

        if(match.type=="0"){
            console.log(match.data);
        }
        else{
            ///print array
        }
        i++;
    }
    //ajax_call("login",JSON.stringify(data));
}
    /* Ajax call */

function ajax_call(ajax_for="",args=""){     ///args represent any argument to be passed
    //var user=getCookie("tree_cookie");
    var url="api/main.php?for="+ajax_for+"&data="+args;
    // var formData = new FormData();
    // formData.append('user', user);
    var request = makeRequest('GET', url);
    if(!request) {
        console.log('Request not supported');
        return;
    }
    // Handle the requests
    request.onreadystatechange = () => {
        if(request.readyState==4&&request.status==200){
            callback_ajax("login",request.responseText);
        }
    };
    request.send();
}

function login_match(){
    var u_name=document.getElementById("u_name");
    var u_password=document.getElementById("u_password");
    var data =new Object;
    data.name=u_name.value;
    data.password=u_password.value;
    data.checkbox=document.getElementById("rememberme").checked;
    ajax_call("login",JSON.stringify(data));
}

function signup(){
    var u_name=document.getElementById("u_name");
    var u_password=document.getElementById("u_password");
    var u_phone=document.getElementById("u_phone");
    var u_lname=document.getElementById("u_lname");
    var data =new Object;
    data.name=u_name.value;
    data.password=u_password.value;
    data.phone=u_phone.value;
    data.lname=u_lname.value;
    ajax_call("signup",JSON.stringify(data));
}