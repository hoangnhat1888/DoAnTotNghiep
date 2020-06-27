/* Storage Helper */

var storage = new LocalStorage();

function LocalStorage() {
	this.setData = function (key, value) {
		localStorage.setItem(key, value);
	}

	this.getData = function (key) {
		return localStorage.getItem(key);
	}

	this.containKey = function (key) {
		return localStorage.getItem(key) !== null ? true : false;
	}

	this.clearData = function (key) {
		localStorage.removeItem(key);
	}

	this.clearStorages = function () {
		localStorage.clear();
	}
}

var session = new SessionStorage();

function SessionStorage() {
	this.setData = function (key, value) {
		sessionStorage.setItem(key, value);
	}

	this.getData = function (key) {
		return sessionStorage.getItem(key);
	}

	this.containKey = function (key) {
		return sessionStorage.getItem(key) !== null ? true : false;
	}

	this.clearData = function (key) {
		sessionStorage.removeItem(key);
	}

	this.clearSessions = function () {
		sessionStorage.clear();
	}
}

var cookie = new CookieStorage();

function CookieStorage() {
	this.setData = function (key, value, expireDays = 1) {
		let currentDate = new Date();
		currentDate.setTime(currentDate.getTime() + (expireDays * 24 * 60 * 60 * 1000));
		let expires = 'expires=' + currentDate.toUTCString();
		document.cookie = key + '=' + value + ';' + expires + ';path=/';
	}

	this.getData = function (key) {
		let name = key + '=';
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for (let i = 0; i < ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
	}

	this.containKey = function (key) {
		return this.getData(key) ? true : false;
	}

	this.clearData = function (key) {
		this.setData(key, '', -1)
	}

	this.clearCookies = function () {
		document.cookie = '';
	}
}
