var App = (function() { 'use strict';

function create_main_fragment(state, component) {
	var section, h1, text, text_1, p, text_2, text_3, text_4, text_5, text_7, section_1, h1_1, text_8, text_9, p_1, text_10, text_11, text_12, text_13, text_15, section_2, h1_2, text_16, text_17, p_2;

	return {
		create: function() {
			section = createElement("section");
			h1 = createElement("h1");
			text = createText("Screen Size");
			text_1 = createText("\n  ");
			p = createElement("p");
			text_2 = createText(state.fullScreenWidth);
			text_3 = createText("px by ");
			text_4 = createText(state.fullScreenHeight);
			text_5 = createText("px");
			text_7 = createText("\n");
			section_1 = createElement("section");
			h1_1 = createElement("h1");
			text_8 = createText("Browser Size");
			text_9 = createText("\n  ");
			p_1 = createElement("p");
			text_10 = createText(state.screenWidth);
			text_11 = createText("px by ");
			text_12 = createText(state.screenHeight);
			text_13 = createText("px");
			text_15 = createText("\n");
			section_2 = createElement("section");
			h1_2 = createElement("h1");
			text_16 = createText("Battery");
			text_17 = createText("\n  ");
			p_2 = createElement("p");
		},

		mount: function(target, anchor) {
			insertNode(section, target, anchor);
			appendNode(h1, section);
			appendNode(text, h1);
			appendNode(text_1, section);
			appendNode(p, section);
			appendNode(text_2, p);
			appendNode(text_3, p);
			appendNode(text_4, p);
			appendNode(text_5, p);
			insertNode(text_7, target, anchor);
			insertNode(section_1, target, anchor);
			appendNode(h1_1, section_1);
			appendNode(text_8, h1_1);
			appendNode(text_9, section_1);
			appendNode(p_1, section_1);
			appendNode(text_10, p_1);
			appendNode(text_11, p_1);
			appendNode(text_12, p_1);
			appendNode(text_13, p_1);
			insertNode(text_15, target, anchor);
			insertNode(section_2, target, anchor);
			appendNode(h1_2, section_2);
			appendNode(text_16, h1_2);
			appendNode(text_17, section_2);
			appendNode(p_2, section_2);
			p_2.innerHTML = state.batteryMessage;
		},

		update: function(changed, state) {
			if ( changed.fullScreenWidth ) {
				text_2.data = state.fullScreenWidth;
			}

			if ( changed.fullScreenHeight ) {
				text_4.data = state.fullScreenHeight;
			}

			if ( changed.screenWidth ) {
				text_10.data = state.screenWidth;
			}

			if ( changed.screenHeight ) {
				text_12.data = state.screenHeight;
			}

			if ( changed.batteryMessage ) {
				p_2.innerHTML = state.batteryMessage;
			}
		},

		unmount: function() {
			p_2.innerHTML = '';

			detachNode(section);
			detachNode(text_7);
			detachNode(section_1);
			detachNode(text_15);
			detachNode(section_2);
		},

		destroy: noop
	};
}

function App(options) {
	this.options = options;
	this._state = options.data || {};

	this._observers = {
		pre: Object.create(null),
		post: Object.create(null)
	};

	this._handlers = Object.create(null);

	this._root = options._root || this;
	this._yield = options._yield;
	this._bind = options._bind;

	this._fragment = create_main_fragment(this._state, this);

	if (options.target) {
		this._fragment.create();
		this._fragment.mount(options.target, options.anchor || null);
	}
}

assign(App.prototype, {
 	destroy: destroy,
 	get: get,
 	fire: fire,
 	observe: observe,
 	on: on,
 	set: set,
 	teardown: destroy,
 	_set: _set,
 	_mount: _mount,
 	_unmount: _unmount
 });

App.prototype._recompute = noop;

function createElement(name) {
	return document.createElement(name);
}

function createText(data) {
	return document.createTextNode(data);
}

function insertNode(node, target, anchor) {
	target.insertBefore(node, anchor);
}

function appendNode(node, target) {
	target.appendChild(node);
}

function detachNode(node) {
	node.parentNode.removeChild(node);
}

function noop() {}

function assign(target) {
	var k,
		source,
		i = 1,
		len = arguments.length;
	for (; i < len; i++) {
		source = arguments[i];
		for (k in source) target[k] = source[k];
	}

	return target;
}

function destroy(detach) {
	this.destroy = noop;
	this.fire('destroy');
	this.set = this.get = noop;

	if (detach !== false) this._fragment.unmount();
	this._fragment.destroy();
	this._fragment = this._state = null;
}

function get(key) {
	return key ? this._state[key] : this._state;
}

function fire(eventName, data) {
	var handlers =
		eventName in this._handlers && this._handlers[eventName].slice();
	if (!handlers) return;

	for (var i = 0; i < handlers.length; i += 1) {
		handlers[i].call(this, data);
	}
}

function observe(key, callback, options) {
	var group = options && options.defer
		? this._observers.post
		: this._observers.pre;

	(group[key] || (group[key] = [])).push(callback);

	if (!options || options.init !== false) {
		callback.__calling = true;
		callback.call(this, this._state[key]);
		callback.__calling = false;
	}

	return {
		cancel: function() {
			var index = group[key].indexOf(callback);
			if (~index) group[key].splice(index, 1);
		}
	};
}

function on(eventName, handler) {
	if (eventName === 'teardown') return this.on('destroy', handler);

	var handlers = this._handlers[eventName] || (this._handlers[eventName] = []);
	handlers.push(handler);

	return {
		cancel: function() {
			var index = handlers.indexOf(handler);
			if (~index) handlers.splice(index, 1);
		}
	};
}

function set(newState) {
	this._set(assign({}, newState));
	if (this._root._lock) return;
	this._root._lock = true;
	callAll(this._root._beforecreate);
	callAll(this._root._oncreate);
	callAll(this._root._aftercreate);
	this._root._lock = false;
}

function _set(newState) {
	var oldState = this._state,
		changed = {},
		dirty = false;

	for (var key in newState) {
		if (differs(newState[key], oldState[key])) changed[key] = dirty = true;
	}
	if (!dirty) return;

	this._state = assign({}, oldState, newState);
	this._recompute(changed, this._state, oldState, false);
	if (this._bind) this._bind(changed, this._state);
	dispatchObservers(this, this._observers.pre, changed, this._state, oldState);
	this._fragment.update(changed, this._state);
	dispatchObservers(this, this._observers.post, changed, this._state, oldState);
}

function _mount(target, anchor) {
	this._fragment.mount(target, anchor);
}

function _unmount() {
	this._fragment.unmount();
}

function callAll(fns) {
	while (fns && fns.length) fns.pop()();
}

function differs(a, b) {
	return a !== b || ((a && typeof a === 'object') || typeof a === 'function');
}

function dispatchObservers(component, group, changed, newState, oldState) {
	for (var key in group) {
		if (!changed[key]) continue;

		var newValue = newState[key];
		var oldValue = oldState[key];

		var callbacks = group[key];
		if (!callbacks) continue;

		for (var i = 0; i < callbacks.length; i += 1) {
			var callback = callbacks[i];
			if (callback.__calling) continue;

			callback.__calling = true;
			callback.call(component, newValue, oldValue);
			callback.__calling = false;
		}
	}
}

return App;

}());