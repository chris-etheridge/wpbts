package com.peachtree.wpbapp;

import android.util.Log;
import android.widget.Toast;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Networking;

import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

import static android.content.ContentValues.TAG;

public class FirebaseInstanceService extends FirebaseInstanceIdService {

    private static Networking API_HELPER;
    private String USER_UPDATE_DEVICE_TOKEN_API = API_HELPER.GetApiBaseUrl() +  "/api/firebase/device_token_registration.php";

    public FirebaseInstanceService() {
        API_HELPER = new Networking(this.getApplicationContext());
    }

    @Override
    public void onTokenRefresh() {
        // Get updated InstanceID token.
        String refreshedToken = FirebaseInstanceId.getInstance().getToken();
        Log.d(TAG, "Refreshed token: " + refreshedToken);

        // If you want to send messages to this application instance or
        // manage this apps subscriptions on the server side, send the
        // Instance ID token to your app server.

        sendRegistrationToServer(refreshedToken);
    }

    protected void sendRegistrationToServer(String newToken) //TODO: Needs to be invoked on user login and/or register
    {
        //send newToken and logged in user id to server

        JSONObject params = new JSONObject();

        try {
            params.put("userid", "1"); //TODO: get current user ID
            params.put("devicetoken", newToken);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Networking.Post(USER_UPDATE_DEVICE_TOKEN_API, params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
                try {
                    String message = o.getString("message");

                    Toast.makeText(getApplicationContext(), message, Toast.LENGTH_LONG);

                } catch (JSONException e) {

                }
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
                String msg = "";

                try {
                    msg = response.getString("message");
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                Toast.makeText(getApplicationContext(), msg, Toast.LENGTH_LONG);

            }
        });

    }

}
