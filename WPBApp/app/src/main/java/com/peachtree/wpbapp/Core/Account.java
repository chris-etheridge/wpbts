package com.peachtree.wpbapp.Core;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.peachtree.wpbapp.Core.impl.UserNotLoggedInException;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.Entities.User;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;
import cz.msebera.android.httpclient.entity.StringEntity;

/**
 * Functions to manage the user account.
 * Default constructor will try log the user in, or get the currently logged in user.
 */
public class Account {

    private User CURRENT_USER = null;

    private static Networking API_HELPER;

    private Context CURRENT_CONTEXT;

    private String USER_LOGIN_API_URL;
    private String USER_REGISTER_API_URL;

    public Account(Context ctx, String email, String password, JsonHttpResponseHandler handler) {
        CURRENT_CONTEXT = ctx;
        API_HELPER = new Networking(CURRENT_CONTEXT);

        USER_LOGIN_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_LOGIN);
        USER_REGISTER_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_REGISTER);

        logIn(email, password, handler);
    }

    public void logIn(String email, String password, JsonHttpResponseHandler handler) {
        if(!logged_in_q()) {
            JSONObject params = new JSONObject();

            try {
                params.put("email", email);
                params.put("pwd", password);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            Networking.Post(USER_LOGIN_API_URL, params, handler);

        }
    }

    // log the current user out
    public void LogOut(String email) {

    }

    public void LogOut(String email, AsyncHttpResponseHandler handler) {

    }

    // check if a user is logged in
    public boolean IsLoggedIn(String email) {
        return CURRENT_USER != null;
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
