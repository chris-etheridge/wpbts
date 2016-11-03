package com.peachtree.wpbapp.Entities;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 * Event entity class.
 */
public class Event {

    // date formatting
    private static SimpleDateFormat fmt = new SimpleDateFormat("dd-MM-yyyy");

    // returns a pretty format of the date
    public static String getDateString(Date date){
        DateFormat format = new SimpleDateFormat("dd MMMM yyyy");

        return format.format(date);
    }

    // Event fields
    private int id;
    private Date date;
    private String title;
    private String city;
    private String office;
    private String street_no;
    private String street;
    private String area;
    private String area_code;
    private String building_number;
    private String description;
    private double lat, lng;

    public Event() { }

    public Event(int id, Date date, String title){
        this.id = id;
        this.date = date;
        this.title = title;
    }

    public Event(int id, Date date, String title, String description){
        this.id = id;
        this.date = date;
        this.title = title;
        this.description = description;
    }

    public Event(int id, Date date, String title, String description, String city, String office,
                 String street_no, String street, String area, String area_code,
                 String building_number, double lat, double lng) {
        this.id = id;
        this.date = date;
        this.title = title;
        this.description = description;
        this.city = city;
        this.office = office;
        this.street_no = street_no;
        this.street = street;
        this.area = area;
        this.area_code = area_code;
        this.building_number = building_number;
        this.lat = lat;
        this.lng = lng;
    }


    // parses many events from a JSON array
    public static ArrayList<Event> EventsFromJsonArray(JSONArray a) throws JSONException, ParseException {
        ArrayList<Event> es = new ArrayList<>();

        // loop through the array
        for(int i = 0; i < a.length(); i++) {
            es.add(EventFromJsonObject(a.getJSONObject(i)));
        }

        return es;
    }

    // parses one event from a JSON object
    public static Event EventFromJsonObject(JSONObject o) throws JSONException, ParseException {
        int id = Integer.parseInt(o.getString("event_id"));
        Date date = fmt.parse(o.getString("event_date"));
        String title = o.getString("title");
        String desc = o.getString("description");
        String city = o.getString("city");
        String office = o.getString("office");
        String street_no = o.getString("street_no");
        String street = o.getString("street");
        String area = o.getString("area");
        String area_code = o.getString("area_code");
        String building_number = o.getString("building_number");

        double lat = o.getDouble("lattitude");
        double lng = o.getDouble("longitude");

        Log.d("EVE", o.getString("event_date"));

        return new Event(id, date, title, desc, city, office, street_no,
                street, area, area_code, building_number, lat, lng);

    }

    // loads the image for the event
    // requires the base API url, and image view to set, and a loader view to hide / show
    public void loadImage(String baseUrl, ImageView view, ProgressBar loaderView) {
        new DownloadImageTask(view, loaderView).execute(baseUrl + "/img/events/" + id + ".jpg");
    }

    // generic task to download an image
    private class DownloadImageTask extends AsyncTask<String, Void, Bitmap> {
        ImageView view;
        ProgressBar loader;

        public DownloadImageTask(ImageView imageView, ProgressBar loaderView) {
            view = imageView;
            loader = loaderView;

            // hide our image view & show loader
            imageView.setVisibility(View.INVISIBLE);
            loaderView.setVisibility(View.VISIBLE);
        }

        protected Bitmap doInBackground(String... urls) {
            String url = urls[0];
            Bitmap image = null;
            try {
                InputStream in = new java.net.URL(url).openStream();
                image = BitmapFactory.decodeStream(in);
            } catch (Exception e) {
                Log.e("Error", e.getMessage());
                e.printStackTrace();
            }
            return image;
        }

        protected void onPostExecute(Bitmap result) {
            view.setImageBitmap(result);

            // show our image view & hide loader
            view.setVisibility(View.VISIBLE);
            loader.setVisibility(View.GONE);
        }
    }

    // - Getters and setters -
    public int getId() {
        return this.id;
    }

    public Date getDate() {
        return this.date;
    }

    public String getTitle() {
        return this.title;
    }

    public String getDescription() {
        return this.description;
    }

    public Double getLat(){return lat;}

    public Double getLng(){return lng;}

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public String getOffice() {
        return office;
    }

    public void setOffice(String office) {
        this.office = office;
    }

    public String getStreet_no() {
        return street_no;
    }

    public void setStreet_no(String street_no) {
        this.street_no = street_no;
    }

    public String getStreet() {
        return street;
    }

    public void setStreet(String street) {
        this.street = street;
    }

    public String getArea() {
        return area;
    }

    public void setArea(String area) {
        this.area = area;
    }

    public String getArea_code() {
        return area_code;
    }

    public void setArea_code(String area_code) {
        this.area_code = area_code;
    }

    public String getBuilding_number() {
        return building_number;
    }

    public void setBuilding_number(String building_number) {
        this.building_number = building_number;
    }

    public String getAddress(){
        String compiledAddress;

        compiledAddress = String.format("%s %s, %s", getStreet_no(), getStreet(), getArea());

        return compiledAddress;
    }
}
