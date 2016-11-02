package com.peachtree.wpbapp.Activity;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.Entities.User;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Core.*;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;

import cz.msebera.android.httpclient.Header;

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
		String u_pass = password.getText().toString();

		// validate both username and password
		if(validateString(u_name)) {
			if(validateString(u_pass)) {
				// create a new account with the username and pass
				Account acc = new Account(CURRENT_CONTEXT, u_name, u_pass, new JsonHttpResponseHandler() {
					@Override
					public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
						boolean error = o.has("error");

						Log.d("API", o.toString());

						// make sure our account is not null
						if(error != true) {
                            // show the home screen
                            Intent loginIntent = new Intent(CURRENT_CONTEXT, Home_Activity.class);

                            startActivity(loginIntent);
                        }
                        // else, there was an internal or network error
                        else {
                            Networking.NetworkingErrors.GenericNetworkingErrorToast(CURRENT_CONTEXT, Toast.LENGTH_SHORT);
                        }
					}

					@Override
					public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
						// handle the error here
						int code = -1;

						try {
							code = Integer.parseInt(response.getString("code"));
						} catch (JSONException e) {
							e.printStackTrace();
						}

						// parse the error
						String message = Networking.NetworkingErrors.GetErrorMessageForCode(code);

					}

					@Override
					public void onFailure(int code, Header[] headers, String m, Throwable t) {
						Log.d("API", "fail" + m);
					}
				});
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
