/* 
 * Debugging functionality
 * 
 * to enable logs for a file define the variable DEBUG to true inside it's 
 * closure
 */

(function(){
    if(window.console === undefined){
        window.console = {
            log: function(){},
            debug: function(){},
            tree: function(){}
        };
    }
    
    function conditionalExec(func){
        
        var enabled = false;
        var executor = function(){
            if(enabled){
               func.apply(console, arguments);
            }
        };
        executor.enable = function (){
            enabled = true;
        };
        executor.disable = function (){
            enabled = false;
        };
        
        return executor;
    }
    
    var debuglog = console.log;
    var debug = console.debug;
    var debugtree = console.debug;
    
    console.log = conditionalExec(debuglog);
    console.debug = conditionalExec(debug);
    console.tree = conditionalExec(debugtree);
})();


