<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <title>日々</title>
    <style type="text/css">
      body{
        background-position:center 50px;
      }
    </style>
  </head>
  <body>
    <!--以下、JavaScript-->
    <script type="text/javascript">
      (function (){ var i=0; 

        // 泡画像のパス指定
        var ha=["assets/remind/img/red_balloon.png","assets/remind/img/blue_balloon.png","assets/remind/img/yellow_balloon.png","assets/remind/img/green_balloon.png","assets/remind/img/pink_balloon.png"];
        var myurl="";
        var haw=50;     // 使用画像の最大実寸横幅
        var hah=50;     // 使用画像の最大実寸縦幅
        var Zx=-1;      // 文章の上に画像が流れるか？　上に流れる：1   下に隠れる：-1
        var num=45; // 流れる画像の数
        var time=50;    // 原本50。画像の流れる間隔1000=1秒。数値が小さいほど速い

        var imgArray=new Array(num);
        var w=window.innerWidth+haw;
        var h=window.innerHeight+hah;
        var lt=window.pageXOffset-haw;
        var tp=window.pageYOffset-hah;
        var imglen=imgArray.length;
        var len=ha.length;

        for(i=0; i<imglen; i++) {
          var img=document.createElement("IMG");
          img.src=myurl+ha[i%len];  
          var ob=img.style;
          ob.position="fixed";/*■absoluteをfixedに変更*/
          ob.left =lt+Math.floor(Math.random()*w)+"px";
          ob.top =tp+Math.floor(Math.random()*h)+"px";
          ob.zIndex=Zx;/*■追加*/
          document.body.appendChild(img);
          imgArray[i]=img;
        }

        function fallLeaves(){
          for(i=0; i<imglen; i++){
            var img=imgArray[i];
            var x=parseInt(img.style.left);
            var y=parseInt(img.style.top);
            y-=2+Math.floor(Math.random()*2);
            /*■下記原本1行変更*/
            if(y<-hah){y=tp+h; x=lt+Math.floor(Math.random()*w);}
            else{ x +=Math.floor(Math.sin(y/40)*2); if(x<lt){x=lt;}else if(x>lt+w){x=lt+w;}}
            img.style.left=x+"px"; img.style.top=y+"px";
          }
          setTimeout(fallLeaves,time); 
        }
        fallLeaves();
      }()); // 即時関数終了
    </script>
</body>
</html>