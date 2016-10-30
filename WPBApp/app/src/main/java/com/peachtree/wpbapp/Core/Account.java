package com.peachtree.wpbapp.Core;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.peachtree.wpbapp.Core.impl.UserNotLoggedInException;
import com.peachtree.wpbapp.Entities.User;

/**
 * Functions to manage the user account.
 * Default constructor will try log the user in, or get the currently logged in user.
 */
public class Account {

    private User CURRENT_USER = null;

    public Account(String email, String password) {
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

    public User LogIn(String email, String password, AsyncHttpResponseHandler handler) {
        if(logged_in_q()) {
            return CURRENT_USER;
        } else {
            return new User();
        }
    }

    // log the current user out
    public void LogOut(String email) {

    }

    public void LogOut(String email, AsyncHttpResponseHandler handler) {

    }

    // check if a user is logged in
    public boolean IsLoggedIn(String email) {
        if(CURRENT_USER != null) {
            return true;
        } else {
            return false;
        }
    }

    // update the user account profile
    public User UpdateProfile(String email) throws UserNotLoggedInException {
        if(logged_in_q()) {
            // do the work

            // return the user
            return CURRENT_USER;
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

    public User Register(String email, AsyncHttpResponseHandler handler) {
        if(logged_in_q()) {
            return CURRENT_USER;
        } else {
            return new User();
        }
    }

    // is the user logged in?
    private boolean logged_in_q() {
        return CURRENT_USER != null;
    }

}
