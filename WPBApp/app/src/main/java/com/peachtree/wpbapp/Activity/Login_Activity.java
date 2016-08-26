package com.peachtree.wpbapp.activity;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import com.peachtree.wpbapp.R;

public class Login_Activity extends AppCompatActivity
{

	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login_activity);

	}

	public void onLoginClick(View view){

		Intent loginIntent = new Intent(this, Event_List_Activity.class);
		startActivity(loginIntent);

	}
}
