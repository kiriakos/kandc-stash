/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


nq = new function NetworkQueue(){
    this.queue = [];
    this.running = 0;
    this.maxOperations = 6;

    this.QueItem = function QueItemConstr(operation, callback) {
        this.execute = function (systemCallback) {
            operation(systemCallback());
            callback();
        };
    };

    this.que = function addResource(operation, callback){
        this.queue.push(new this.QueItem(operation, callback));
    };

    this.process = function processQue(){
        if (thisQue.running < thisQue.maxOperations
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
                function loadImage(clb) {
                    element.attr('src', url);
                    element.load(clb);
                },
                function validate() {
                    //console.log("loading" + url);
                });
    };
    
    thisQue = this;
    setInterval(this.process, 50);
};