package com.peachtree.wpbapp.core;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Core networking implementation.
 */
public class Networking {

    public static JSONObject GetJsonFromUrl(String targetUrl) throws JSONException {
        StringBuffer buf = new StringBuffer("");
        JSONObject returnObj = new JSONObject();

        try {
            URL url = new URL(targetUrl);
            HttpURLConnection httpCon = (HttpURLConnection) url.openConnection();

            BufferedReader bufR = new BufferedReader(new InputStreamReader(httpCon.getInputStream()));

            String line = "";

            while((line = bufR.readLine()) != null) {
                buf.append(line + "\n");
            }

            returnObj.put("status", "success");
            returnObj.put("response", buf);

        } catch (IOException ex) {
            returnObj.put("status", "error");
            returnObj.put("message", ex.getMessage());
        }

        return returnObj;
    }

    public static JSONObject PostJsonToUrl(String url, JSONObject payload) {
        return new JSONObject();
    }

}
