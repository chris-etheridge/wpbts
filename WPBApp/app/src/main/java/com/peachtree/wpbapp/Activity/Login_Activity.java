package com.peachtree.wpbapp.Activity;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Core.*;

public class Login_Activity extends AppCompatActivity
{

	private Account session_account;
	private TextView user, password;

	private Context CURRENT_CONTEXT;

	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login_activity);

		session_account = null;
		user = (TextView)findViewById(R.id.TXT_username);
		password = (TextView)findViewById(R.id.TXT_password);

		CURRENT_CONTEXT = this.getApplicationContext();

	}

	public void onLoginClick(View view){

		// get the text for username and password fields
		String u_name = user.getText().toString();
		String u_pass = user.getText().toString();

		// validate both username and password
		if(validateString(u_name)) {
			if(validateString(u_pass)) {
				// create a new account with the username and pass
				session_account = new Account(CURRENT_CONTEXT ,u_name, u_pass);

				// make sure our account is not null
				if(session_account != null) {
					// show the home screen
					Intent loginIntent = new Intent(this, com.peachtree.wpbapp.Activity.Home_Activity.class);

					startActivity(loginIntent);
				}
				// else, there was an internal or network error
				else {
					Networking.NetworkingErrors.GenericNetworkingErrorToast(CURRENT_CONTEXT, Toast.LENGTH_SHORT);
				}
			} else {
				Toast.makeText(this, "Please enter a password!", Toast.LENGTH_SHORT).show();
			}
		} else {
			Toast.makeText(this, "Please enter a username!", Toast.LENGTH_SHORT).show();
		}
	}

	// validates a string
	// makes sure the length is > 1
	private boolean validateString(String s){
		boolean result = true;

		if(s.length() < 1){
			result = false;
		}

		return result;
	}
}
