package com.peachtree.wpbapp;

import android.app.Service;
import android.content.Intent;
import android.os.IBinder;
import android.util.Log;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.Entities.User;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;

import cz.msebera.android.httpclient.Header;

import static android.content.ContentValues.TAG;

public class FirebaseInstanceService extends FirebaseInstanceIdService {

    private static Networking API_HELPER;
    private String USER_UPDATE_DEVICE_TOKEN_API = API_HELPER.GetApiBaseUrl() +  "/api/firebase/device_token_registration.php";

    public FirebaseInstanceService() {
        API_HELPER = new Networking();
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

    protected void sendRegistrationToServer(String newToken)
    {
        //send newToken and logged in user id to server

        RequestParams params = new RequestParams();

        params.add("userid", "1"); //TODO get current user ID
        params.add("devicetoken", newToken);

        API_HELPER.Post(USER_UPDATE_DEVICE_TOKEN_API, params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
                try {
                    int code = o.getInt("code");
                    String message = o.getString("message");

                    //something else here ??? handle message in case of error -> try again

                } catch (JSONException e) {

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

    }

}
