/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


nq = new function NetworkQueue(){
    this.queue = [];
    this.running = 0;
    this.maxOperations = 4; // 6 for production 
    this.interval = 10; // 20 for production

    this.QueItem = function QueItemConstr(operation, callback) {
        this.execute = function (systemCallback) {
            operation(systemCallback);
            callback();
        };
    };

    this.que = function addResource(operation, callback){
        this.queue.push(new this.QueItem(operation, callback));
    };

    this.process = function processQue(){
        while (thisQue.running < thisQue.maxOperations
                && thisQue.queue.length)
        {
            var op = thisQue.queue.shift();
            thisQue.running++;
            
            op.execute(function () {
                thisQue.running--;
            });   
        }
    };

    this.image = function queImage(url, element){
        this.que(
                function loadImage(callback) {
                    console.log(url);
                    element.attr('src', url);
                    element.load(callback);
                },
                function validate() {
                    //console.log("loading" + url);
                });
    };
    
    var thisQue = this;
    setInterval(this.process, this.interval);
};