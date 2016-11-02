package com.peachtree.wpbapp.Core;

import android.content.Context;
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

    public Account(Context ctx, String email, String password) {
        CURRENT_CONTEXT = ctx;
        API_HELPER = new Networking(CURRENT_CONTEXT);

        USER_LOGIN_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_LOGIN);
        USER_REGISTER_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.USER_REGISTER);

        LogIn(email, password);
    }

    public User LogIn(String email, String password) {
        if(logged_in_q()) {
            return CURRENT_USER;
        } else {
            RequestParams params = new RequestParams();

            params.add("email", email);
            params.add("pwd", password);

            API_HELPER.Post(USER_LOGIN_API_URL, params, new JsonHttpResponseHandler() {
                @Override
                public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
                    try {
                        JSONObject u = o.getJSONObject("user");

                        User user = User.UserFromJsonObject(u);

                        CURRENT_USER = user;
                    } catch (JSONException e) {

                    } catch (ParseException e) {
                        e.printStackTrace();
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
            });

            return CURRENT_USER;
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
