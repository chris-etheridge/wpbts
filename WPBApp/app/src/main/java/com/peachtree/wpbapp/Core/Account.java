package com.peachtree.wpbapp.Core;

import android.app.Activity;
import android.util.Log;

import com.peachtree.wpbapp.Core.impl.Generic;
import com.peachtree.wpbapp.Core.impl.UserNotLoggedInException;
import com.peachtree.wpbapp.Entities.User;
import com.peachtree.wpbapp.R;

/**
 * Functions to manage the user account.
 * Default constructor will try log the user in, or get the currently logged in user.
 */
public class Account extends Generic {

    private User CURRENT_USER = null;

    public Account(String api_url, String email, String password) {
        super(api_url);

        LogIn(email, password);
    }

    // log a new user in
    public User LogIn(String email, String password) {
        if(logged_in_q()) {
            return CURRENT_USER;
        } else {
            return new User();
        }
    }

    // log the current user out
    public void LogOut(String email) {}

    // check if a user is logged in
    public void IsLoggedIn(String email) {}

    // update the user account profile
    public void UpdateProfile(String email) throws UserNotLoggedInException {
        if(logged_in_q()) {

        } else {
            throw new UserNotLoggedInException();
        }
    }

    // register a new user
    public User Register(String email) {
        if(logged_in_q()) {
            return CURRENT_USER;
        } else {
            // create account and log the user in
            return new User();
        }
    }

    private boolean logged_in_q() {
        return CURRENT_USER != null;
    }

}
