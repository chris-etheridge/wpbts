package com.peachtree.wpbapp.activity;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.core.*;

public class Login_Activity extends AppCompatActivity
{

	private Account session_Account;
	private TextView user, password;

	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login_activity);

		session_Account = null;
		user = (TextView)findViewById(R.id.TXT_username);
		password = (TextView)findViewById(R.id.TXT_password);
	}

	public void onLoginClick(View view){

		if(validateUsername()){
			session_Account = new Account(user.getText().toString(), password.getText().toString());
		}

		Intent loginIntent = new Intent(this, Event_List_Activity.class);
		startActivity(loginIntent);
	}

	private boolean validateUsername(){
		boolean result = true;

		if(user.getText().length() < 1){
			result = false;
		}

		return result;
	}
}
