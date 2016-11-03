package com.peachtree.wpbapp.Activity;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import com.peachtree.wpbapp.Core.Account;
import com.peachtree.wpbapp.R;

public class Register_Activity extends AppCompatActivity
{

	private Account ACCOUNTS_HELPER;

	private TextView userName, password, email, address, cellNumber;
	private ImageButton user_info, pass_info, email_info, address_info, cell_info;

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

		user_info = (ImageButton)findViewById(R.id.info_user);
		pass_info = (ImageButton)findViewById(R.id.info_password);
		email_info = (ImageButton)findViewById(R.id.info_email);
		address_info = (ImageButton)findViewById(R.id.info_address);
		cell_info = (ImageButton)findViewById(R.id.info_phone);

		user_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "The name we will know you by.", Toast.LENGTH_SHORT).show();
			}
		});

		pass_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "The password you will use to sign in to our app.", Toast.LENGTH_SHORT).show();
			}
		});

		email_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "The email we can use to contact you, this will also be used by you to sign in.", Toast.LENGTH_SHORT).show();
			}
		});

		address_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "You're residential address.", Toast.LENGTH_SHORT).show();
			}
		});

		cell_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "You're main contact phone number.", Toast.LENGTH_SHORT).show();
			}
		});
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
