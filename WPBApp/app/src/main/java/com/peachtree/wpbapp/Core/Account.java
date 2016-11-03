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
 * Account API helper.
 * Default constructor will try log the user in, or get the currently logged in user.
 */
public class Account {

    // stores the current user
    private User CURRENT_USER = null;

    // API helper
    private static Networking API_HELPER;

    // current calling context
    private Context CURRENT_CONTEXT;

    private String USER_LOGIN_API_URL;
    private String USER_REGISTER_API_URL;

    // creates a new Account helper
    public Account(Context ctx, String email, String password, JsonHttpResponseHandler handler) {
        CURRENT_CONTEXT = ctx;
        API_HELPER = new Networking(CURRENT_CONTEXT);

        // setup the API urls
        USER_LOGIN_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_LOGIN);
        USER_REGISTER_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_REGISTER);

        // log the user in
        logIn(email, password, handler);
    }

    public Account(Context ctx) {
        CURRENT_CONTEXT = ctx;
        API_HELPER = new Networking(CURRENT_CONTEXT);

        // setup the API urls
        USER_LOGIN_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_LOGIN);
        USER_REGISTER_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_REGISTER);
    }

    // logs the user in, with email and password, and calls the handler
    public void logIn(String email, String password, JsonHttpResponseHandler handler) {
        // first make sure the user is not logged in
        if(!logged_in_q()) {
            // set up our params
            JSONObject params = new JSONObject();

            try {
                params.put("email", email);
                params.put("pwd", password);
            } catch (JSONException e) {
                e.printStackTrace();
            }

            // do a post with the params and handler
            Networking.Post(USER_LOGIN_API_URL, params, handler);
        }
    }

    // Register the user, and call the handler
    public void Register(String email, String first_name, String last_name, String password,
                         String address, String cell, AsyncHttpResponseHandler handler) {

        JSONObject params = new JSONObject();

        try {
            params.put("email", email);
            params.put("first_name", first_name);
            params.put("last_name", last_name);
            params.put("pwd", password);
            params.put("address", address);
            params.put("cell", cell);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Networking.Post(USER_REGISTER_API_URL, params, handler);
    }

    // is the user logged in?
    private boolean logged_in_q() {
        return CURRENT_USER != null;
    }

}
