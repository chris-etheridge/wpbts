package com.peachtree.wpbapp.Activity;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import com.peachtree.wpbapp.Core.Account;
import com.peachtree.wpbapp.R;

public class Register_Activity extends AppCompatActivity
{

	private Account ACCOUNTS_HELPER;

	private TextView userName, password, email, address, cellNumber;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.register_activity);

		// set up all our fields
		userName = (TextView) findViewById(R.id.register_txt_username);
		password = (TextView) findViewById(R.id.register_txt_password);
		email = (TextView) findViewById(R.id.register_txt_email);
		address = (TextView) findViewById(R.id.register_txt_address);
		cellNumber = (TextView) findViewById(R.id.register_txt_cell);
	}

	public void onRegisterButtonClicked(View v) {
		// get all our text
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
