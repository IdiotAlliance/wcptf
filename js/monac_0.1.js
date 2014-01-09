function unit(args){
	return function(onComplete, onFail){
		onComplete(args);
	}
}

function unit(f, args){
	return function(onComplete, onFail){
		f(args, onComplete, onFail);
	}
}

function bind(M, f){
	return function(onComplete, onFail){
		M(function(result){f(result)(onComplete, onFail);}, onFail);
	}
}