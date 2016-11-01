package com.peachtree.wpbapp.Entities;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;

/**
 * Entity that models a User.
 */
public class User {

    private String firstName;
    private String lastName;
    private String email;
    private String address;
    private String hashedPassword;

    public User() { }

    public User(String email, String firstName, String lastName, String address, String password) {
        this.email = email;
        this.firstName = firstName;
        this.lastName = lastName;
        this.address = address;
        this.hashedPassword = password;
    }

    public static ArrayList<User> UsersFromJsonArray(JSONArray a) throws JSONException, ParseException {
        ArrayList<User> es = new ArrayList<>();

        for(int i = 0; i < a.length(); i++) {
            es.add(UserFromJsonObject(a.getJSONObject(i)));
        }

        return es;
    }

    public static User UserFromJsonObject(JSONObject o) throws JSONException, ParseException {
        String email = o.getString("EMAIL");
        String first = o.getString("FIRST_NAME");
        String last = o.getString("LAST_NAME");
        String address = o.getString("ADDRESS");
        String password = o.getString("PWD");


        return new User(email, first, last, address, password);

    }

    public String getFirstName() {
        return this.firstName;
    }

    public String getLastName() {
        return this.lastName;
    }

    public String getEmail() {
        return this.email;
    }

    public String getAddress() {
        return this.address;
    }

    public String getHashedPassword() {
        return this.hashedPassword;
    }

}
