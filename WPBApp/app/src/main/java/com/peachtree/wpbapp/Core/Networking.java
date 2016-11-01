package com.peachtree.wpbapp.Core;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.peachtree.wpbapp.Core.impl.Core;
import com.peachtree.wpbapp.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Collection;
import java.util.HashMap;
import java.util.Map;
import java.util.Set;

/**
 * Core networking implementation.
 * Uses android-async-http http://loopj.com/android-async-http/
 */
public class Networking {

    private String INTERNAL_HOST_URL;

    private Context CURRENT_CONTEXT;

    public Networking(Context ctx) {
        CURRENT_CONTEXT = ctx;

        INTERNAL_HOST_URL = ctx.getResources().getString(R.string.API_BASE);

    }

    public String GetApiBaseUrl() {
        return INTERNAL_HOST_URL;
    }

    private static AsyncHttpClient HTTP_CLIENT = new AsyncHttpClient();

    public static void Get(String url, RequestParams params, AsyncHttpResponseHandler response_handler) {
        Log.d("API", "Performing _GET_ to URL => " + url);

        HTTP_CLIENT.get(url, params, response_handler);
    }

    public static void Post(String url, RequestParams params, AsyncHttpResponseHandler response_handler) {
        Log.d("API", "Performing _POST_ to URL => " + url);

        HTTP_CLIENT.post(url, params, response_handler);
    }

    // checks if a response okay
    public static boolean ResponseIsOkay_q(JSONObject response) {
        String d = "";
        boolean passed = false;

        try {
            d = response.getString("status");
        } catch (JSONException e) {
            passed = false;

            return passed;
        }

        if(!d.equals("error")) {
            passed = true;
        } else {
            passed = false;
        }

        return passed;
    }

    public static class NetworkingErrors {

        // generic event codes
        public static int ERROR_UNKNOWN_DB_ERROR = 222;
        public static int ERROR_INCORRECT_STRING_FORMAT = 155;
        public static int ERROR_DATABASE_UNAVALIABLE = 113;

        public static int LOGIN_ERROR_USER_DOES_NOT_EXIST = 111;
        public static int LOGIN_ERROR_SCRIPT_NOT_IMPLEMENTED = 114;
        public static int LOGIN_ERROR_AUTHENTICATION_FAILURE = 181;
        public static int REG_ERROR_USER_EMAIL_EXISTS = 111;
        public static int PROFILE_ERROR_GENERIC = 111;
        public static int RSVP_ERROR_NOT_ALL_VALUES_PROVIDED = 443;
        public static int RSVP_ERROR_ILLEGAL_OPT_IN_VALUE = 444;
        public static int RSVP_ERROR_UNKNOWN_DB_ERROR = 445;
        public static int EVENT_ERROR_NO_ID_SPECIFIED = 223;
        public static int CLINIC_GET_NO_ID_SPECIFIED = 333;

        // build a hashmap that contains errors -> human-readable messaages
        private static final HashMap<Integer, String> ERRORS_INDEX = new HashMap<>();

        static {
            ERRORS_INDEX.put(ERROR_UNKNOWN_DB_ERROR, "Unknown database error occured.");
            ERRORS_INDEX.put(ERROR_INCORRECT_STRING_FORMAT, "Incorrect string format provided.");
            ERRORS_INDEX.put(ERROR_DATABASE_UNAVALIABLE, "Database is not avaliable.");
            ERRORS_INDEX.put(LOGIN_ERROR_USER_DOES_NOT_EXIST, "The user specified does not exist.");
            ERRORS_INDEX.put(LOGIN_ERROR_SCRIPT_NOT_IMPLEMENTED, "Script specified during login is not implemented.");
            ERRORS_INDEX.put(LOGIN_ERROR_AUTHENTICATION_FAILURE, "Failed to authenticate the user.");
            ERRORS_INDEX.put(REG_ERROR_USER_EMAIL_EXISTS, "A user with that email already exists.");
            ERRORS_INDEX.put(PROFILE_ERROR_GENERIC, "There was a problem updating your profile.");
            ERRORS_INDEX.put(RSVP_ERROR_NOT_ALL_VALUES_PROVIDED, "Some information required for RSVP was blank.");
            ERRORS_INDEX.put(RSVP_ERROR_ILLEGAL_OPT_IN_VALUE, "The wrong value to opt in for the RSVP was given.");
            ERRORS_INDEX.put(RSVP_ERROR_UNKNOWN_DB_ERROR, "During the RSVP, an uknown database error ocurred.");
            ERRORS_INDEX.put(EVENT_ERROR_NO_ID_SPECIFIED, "No ID for the event was specified.");
            ERRORS_INDEX.put(CLINIC_GET_NO_ID_SPECIFIED, "No ID for the clinic was specified.");
        }

        public static String GetErrorMessageForCode(int code) {
            String msg = "";

            try {
                msg = ERRORS_INDEX.get(code);
            } catch(Exception e) {
                msg = "Unknown error occurred.";
            }

            return msg;
        }

        public static void GenericNetworkingErrorToast(Context ctx, int duration) {
            Toast.makeText(ctx, "There was a networking error, please try again in a few moments.", duration);
        }
    }

}
