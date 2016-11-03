package com.peachtree.wpbapp.Core;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.peachtree.wpbapp.R;

import org.json.JSONObject;

import java.io.UnsupportedEncodingException;

import cz.msebera.android.httpclient.entity.StringEntity;
import cz.msebera.android.httpclient.message.BasicHeader;
import cz.msebera.android.httpclient.protocol.HTTP;

/**
 * Core networking implementation.
 * Uses android-async-http http://loopj.com/android-async-http/
 */
public class Networking {

    // internal base API url
    private String INTERNAL_HOST_URL;

    // current calling context
    private static Context CURRENT_CONTEXT;

    // creates a new networking helper
    public Networking(Context ctx) {
        CURRENT_CONTEXT = ctx;

        INTERNAL_HOST_URL = ctx.getResources().getString(R.string.API_BASE);
    }

    // returns the base API url
    public String GetApiBaseUrl() {
        return INTERNAL_HOST_URL;
    }

    // HTTP client, for http requests
    private static AsyncHttpClient HTTP_CLIENT = new AsyncHttpClient();

    // performs a GET request URL
    // with params
    // calls the AsyncResponseHandler during the request
    public static void Get(String url, RequestParams params, AsyncHttpResponseHandler response_handler) {
        // log our request with the url
        Log.d("API", "Performing _GET_ to URL => " + url);

        // perform the GET
        HTTP_CLIENT.get(url, params, response_handler);
    }

    // performs a POST request to URL
    // with JSON params
    // calls the AsyncResponseHandler during the request
    public static void Post(String url, JSONObject params, AsyncHttpResponseHandler response_handler) {
        // log our request with the URL
        Log.d("API", "Performing _POST_ to URL => " + url);

        // parse the JSON object into a string entity
        StringEntity e = null;
        try {
            e = new StringEntity(params.toString());
        } catch (UnsupportedEncodingException e1) {
            e1.printStackTrace();
        }

        // set the content type headers to application/json
        e.setContentType(new BasicHeader(HTTP.CONTENT_TYPE, "application/json"));

        // POST with the entity, the URL, the headers, and the response handler
        HTTP_CLIENT.post(null, url, e, "application/json", response_handler);
    }

    // basic networking errors helper class
    public static class NetworkingErrors {
        // shows a generic networking error toast
        public static void GenericNetworkingErrorToast(Context ctx, int duration) {
            Toast.makeText(ctx,
                    "There was a networking error, please try again in a few moments.",
                    duration).show();
        }
    }

}
