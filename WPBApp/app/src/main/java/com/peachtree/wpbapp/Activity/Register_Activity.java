package com.peachtree.wpbapp.Activity;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Account;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.R;

import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

public class Register_Activity extends AppCompatActivity
{

	private Account ACCOUNTS_HELPER;

	private TextView firstName, surname, password, email, address, cellNumber;
	private ImageButton fname_info, sname_info, pass_info, email_info, address_info, cell_info;

	private Context CURRENT_CONTEXT;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.register_activity);

		// set up all our fields
		firstName = (TextView) findViewById(R.id.register_txt_fname);
		surname = (TextView) findViewById(R.id.register_txt_surname);
		password = (TextView) findViewById(R.id.register_txt_password);
		email = (TextView) findViewById(R.id.register_txt_email);
		address = (TextView) findViewById(R.id.register_txt_address);
		cellNumber = (TextView) findViewById(R.id.register_txt_cell);

		fname_info = (ImageButton)findViewById(R.id.info_fName);
		sname_info = (ImageButton) findViewById(R.id.info_surname);
		pass_info = (ImageButton)findViewById(R.id.info_password);
		email_info = (ImageButton)findViewById(R.id.info_email);
		address_info = (ImageButton)findViewById(R.id.info_address);
		cell_info = (ImageButton)findViewById(R.id.info_phone);

		CURRENT_CONTEXT = getApplicationContext();

		ACCOUNTS_HELPER = new Account(CURRENT_CONTEXT);

		fname_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "Your first name.", Toast.LENGTH_SHORT).show();
			}
		});

		sname_info.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Toast.makeText(Register_Activity.this, "Your surname/family name.", Toast.LENGTH_SHORT).show();
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
		final ProgressDialog progress = new ProgressDialog(this);

		progress.setTitle("Please wait");
		progress.setMessage("We are registering you.");

		String user_email = email.getText().toString();
		String first = firstName.getText().toString();
		String last = surname.getText().toString();
		String pass = password.getText().toString();
		String a = address.getText().toString();
		String cell = cellNumber.getText().toString();

		ACCOUNTS_HELPER.Register(user_email, first, last, pass, a, cell, new JsonHttpResponseHandler(){
			@Override
			public void onStart() {
				progress.show();
			}

			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
				progress.hide();

				boolean error = o.has("error");

				// make sure our account is not null
				if(error != true) {
					// show the home screen
					Intent loginIntent = new Intent(CURRENT_CONTEXT, Home_Activity.class);

					// get the current user id
					int id = 0;
					try {
						id = o.getJSONObject("user").getInt("userID");
					} catch (JSONException e) {
						e.printStackTrace();
					}

					// preference key to save the user id
					String prefKey = getApplicationContext().getString(R.string.user_id_perference_key);

					// get the shared preferences
					SharedPreferences prefs =
							CURRENT_CONTEXT.getSharedPreferences("com.peachtree.wpbapp", MODE_PRIVATE);

					// save our user id to the preferences
					prefs.edit().putInt(prefKey, id).apply();

					startActivity(loginIntent);
				}
				// else, there was an internal or network error
				else {
					Networking.NetworkingErrors.GenericNetworkingErrorToast(CURRENT_CONTEXT, Toast.LENGTH_SHORT);
				}
			}

			@Override
			public void onFinish() {
				progress.hide();
			}
		});
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
