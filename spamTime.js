function enviar(input, mensaje) {
        InputEvent = Event || InputEvent;
        var evt = new InputEvent('input', {						
            bubbles: true,
	    	composer: true
        });
        input.innerHTML = mensaje;								
        input.dispatchEvent(evt);								
        document.querySelector("#main > footer > div._3pkkz.copyable-area > div:nth-child(3) > button > span").click();
    }
function spam(){
    // LA BUENAAAAAAAAAAAAAAAAAA PERROSSSSSSSSSSSSSSSSSSSS
        var input = document.querySelector("#main > footer > div._3pkkz.copyable-area > div._1Plpp > div > div._2S1VP.copyable-text.selectable-text");											
        var contador=1;
        setInterval(function(){
            if(contador%3600==0){
                enviar(input, "hora "+(contador/3600));
            }else if(contador%60==0){
                enviar(input, "minuto "+(contador/60));
            }else{
                enviar(input, "Segundo "+contador);
            }
            contador+=3;
        },3000);
    }
spam();