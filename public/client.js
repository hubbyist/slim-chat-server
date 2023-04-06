/*
# ---------------------------------------------------------------------------- *
#
# LICENSE UNDECIDED
#
# ---------------------------------------------------------------------------- *
# Copyright 2023 Mehmet Durgel. All Rights Reserved.
# ---------------------------------------------------------------------------- *
# @author Mehmet Durgel<md@legrud.net>
# ---------------------------------------------------------------------------- *
*/
var datas = {
	dialog: {
		id: 1,
	}
}
document.addEventListener('DOMContentLoaded', function () {
	var components = {
		"dialog-content": document.querySelector("#dialog-content"),
		form: document.querySelector("form"),
		"message-content": document.querySelector("#message-content"),
	}
	components['form'].addEventListener('submit', function (event) {
		event.preventDefault();

		var method = event.target.attributes.method.value;
		var message = components['message-content'].value;
		var action = message.startsWith('Login::') ? '/users/login' : '/dialogs/' + datas.dialog.id + '/message';

		var input = null;
		switch (action) {
			case '/users/login':
				var credentials = message.replace('Login::', '').split(' ');
				console.log(credentials);
				input = {"username": credentials[0], "password": credentials[1]};
				break;
			default:
				input = {"message": message};
		}
		fetch(action, {
			method: method,
			body: JSON.stringify(input),
			credentials: 'same-origin',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
			},
		}).then((response) => {
			response.json().then((json) => {
				console.log('message');
				var output = '';
				if (json['message']) {
					output = json['message'];
				} else if (json['messages']) {
					output = json['messages'].join("\n");
				} else {
					output = JSON.stringify(json, null, "\t");
				}
				components['dialog-content'].value += output + "\n";
				components['dialog-content'].scrollTop = components['dialog-content'].scrollHeight;
			});
		}).catch(
				(error) => alert(error)
		).finally(() => {
			components['message-content'].value = '';
		});
	});
}, false);
