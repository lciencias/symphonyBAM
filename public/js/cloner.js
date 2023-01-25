/**
 * 
 * <p>This function is to clone anything and to append wherever you what to. All you
 * need is:</p>
 * 
 * <p>An element id=cloner with at least two attributes:</p>
 * <ul> 
 * <li>-clones (this will give the index)</li>
 * <li>-parent-id (where the element is going to be append)</li>
 * <li>-base (optional, to define the base clone in case of multiple cloners)</li>
 * <li>-The whole pack to be cloned must have id="base"</li>
 * </ul>
 * <p>All inputs, selects , etc that are going to be modified required an attribute
 * called basename in which you must set the basename but replacing index with %
 * and the class indexable</p>
 * 
 * <p>The inputs can have the class exact-clone to keep current value</p>
 * 
 * <p>Wherever you want to use it you have to set the function afterCloning(), with 
 * all the thing that you what to do after cloning</p>
 * <p>UPDATE: exclude all elements from being cloned while having removable class</p>
 * @author joseluis
 * 
 */
function clone() {
	var clone;
	var parentId = '#' + $(this).attr('parent-id');
	var index = Number($(this).attr('clones')) + 1;
	cloneId = 'clone' + index + parseInt(Math.random()*1000);
	$(this).attr('clones', index);
	$(this).attr('index', index);
	if ($(this).attr('base')) {
		base = $(this).attr('base');
		clone = $('#' + base).clone();
	} else {
		base = $(this).attr('base');
		if(base==null){
			clone = $('#base').clone();
		}else{
			clone = $('#'+base).clone();
		}
		
	}
	clone.attr('id', cloneId);
	clone.find('label').each(function() {
		if ($(this).hasClass('error')) {
			$(this).remove();
		}
	});
	baseId = clone.attr('baseid');
	clone.find('#' + baseId).each(function() {
		$(this).remove();
	});
	clone.find('#status').each(function() {
		$(this).remove();
	});

	// this must be removed
	clone.find('i').each(function() {
		$(this).attr('class', 'icon-minus-sign');
	});
	//
	clone.find('#cloner').attr('id', 'remover');
	clone.find('#remover').attr('for', cloneId);
	clone.find('#remover').click(remove);
	clone.find('.indexable').each(function() {
		if (!$(this).hasClass('exact-clone')) {
			$(this).attr('value', null);
		}
		baseName = $(this).attr('basename');
		name = baseName.replace(/%/g, index);
		$(this).attr('name', name);
		$(this).attr('index', index);
		id = $(this).attr('id').replace(/0/g,'');
		$(this).attr('id', id + index);
	});
	clone.find('.removable').each(function(){
		$(this).remove();
	});
	clone.appendTo(parentId);
	afterCloning(clone, index);
};

/**
 * In this case the attr base in clone botton is required and a callback identifier
 */
function multipleClones() {
	var clone;
	var parentId = '#' + $(this).attr('parent-id');
	var index = Number($(this).attr('clones')) + 1;
	cloneId = 'clone' + index + parseInt(Math.random()*1000);
	$(this).attr('clones', index);
	$(this).attr('index', index);
	if ($(this).attr('base')) {
		base = $(this).attr('base');
		clone = $('#' + base).clone();
	} else {
		base = $(this).attr('base');
		if(base==null){
			clone = $('#base').clone();
		}else{
			clone = $('#'+base).clone();
		}
		
	}
	callback = $(this).attr('callBack');
	clone.attr('id', cloneId);
	clone.find('label').each(function() {
		if ($(this).hasClass('error')) {
			$(this).remove();
		}
	});
	baseId = clone.attr('baseid');
	clone.find('#' + baseId).each(function() {
		$(this).remove();
	});
	clone.find('#status').each(function() {
		$(this).remove();
	});

	clone.find('#cloner').attr('id', 'remover');
	clone.find('#remover').attr('for', cloneId);
	clone.find('#remover').click(remove);
	clone.find('.indexable').each(function() {
		if (!$(this).hasClass('exact-clone')) {
			$(this).attr('value', null);
		}
		baseName = $(this).attr('basename');
		name = baseName.replace(/%/g, index);
		$(this).attr('name', name);
		$(this).attr('index', index);
		id = $(this).attr('id').replace(/0/g,'');
		$(this).attr('id', id + index);
	});
	clone.find('.removable').each(function(){
		$(this).remove();
	});
	clone.appendTo(parentId);
	callbackAction(clone, index, callback);
};
function remove(){
	element = '#' + $(this).attr('for');
	callback = $(this).attr('callback');
	$(element).remove();	
}