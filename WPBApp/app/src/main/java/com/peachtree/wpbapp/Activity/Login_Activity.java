package com.peachtree.wpbapp.Activity;

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

	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login_activity);

		session_account = null;
		user = (TextView)findViewById(R.id.TXT_username);
		password = (TextView)findViewById(R.id.TXT_password);
	}

	public void onLoginClick(View view){

		if(validateUsername()){
			session_account = new Account(user.getText().toString(), password.getText().toString());

			if(session_account != null) {
				Intent loginIntent = new Intent(this, Home_Activity.class);

				startActivity(loginIntent);
			} else {
				Toast.makeText(this,
						"There was an error logging you in, please try again in a few minutes!",
						Toast.LENGTH_SHORT).show();
			}
		} else {
			Toast.makeText(this, "Please enter a username!", Toast.LENGTH_SHORT).show();
		}
	}

	private boolean validateUsername(){
		boolean result = true;

		if(user.getText().length() < 1){
			result = false;
		}

		return result;
	}
}
