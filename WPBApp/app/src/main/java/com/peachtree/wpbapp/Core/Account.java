package com.peachtree.wpbapp.core;

import android.app.Activity;

import com.peachtree.wpbapp.R;

/**
 * Functions to manage the user account.
 * Default constructor will try log the user in, or get the currently logged in user.
 */
public class Account extends Activity {

    private String ACCOUNT_API_URL = getResources().getString(R.string.API_ACCOUNT_URL);

    // when creating an account object, we should try log that user in
    public Account(String email, String password) {
        LogIn(email, password);
    }

    // log a new user in
    public void LogIn(String email, String password) {}

    // log the current user out
    public void LogOut(String email) {}

    // check if a user is logged in
    public void IsLoggedIn(String email) {}

    // update the user account profile
    public void UpdateProfile(String email) {}

    // register a new user
    public void Register(String email) {}

}
