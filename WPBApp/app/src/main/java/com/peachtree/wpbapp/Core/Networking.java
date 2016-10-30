package com.peachtree.wpbapp.Core;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Core networking implementation.
 * Uses android-async-http http://loopj.com/android-async-http/
 */
public class Networking {

    private static AsyncHttpClient HTTP_CLIENT = new AsyncHttpClient();

    public static void Get(String url, RequestParams params, AsyncHttpResponseHandler response_handler) {
        HTTP_CLIENT.get(url, params, response_handler);
    }

    public static void Post(String url, RequestParams params, AsyncHttpResponseHandler response_handler) {
        HTTP_CLIENT.post(url, params, response_handler);
    }

}
