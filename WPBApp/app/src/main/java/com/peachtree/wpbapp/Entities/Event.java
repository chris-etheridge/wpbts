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
 * Entity that models an Event.
 */
public class Event {

    private static SimpleDateFormat fmt = new SimpleDateFormat("mm-dd-yyyy");

    public static String getDateString(Date date){
		DateFormat format = new SimpleDateFormat("dd MMMM yyyy");

		return format.format(date);
	}

    private enum EventType {
        Donation,
        Fundraiser
    }

    private int id;
    private Date date;
    private String address;
    private String title;
    private boolean active;
    private String description;
    private EventType type;
    private int urgency;
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


    public static ArrayList<Event> EventsFromJsonArray(JSONArray a) throws JSONException, ParseException {
        ArrayList<Event> es = new ArrayList<>();

        for(int i = 0; i < a.length(); i++) {
            es.add(EventFromJsonObject(a.getJSONObject(i)));
        }

        return es;
    }

    public static Event EventFromJsonObject(JSONObject o) throws JSONException, ParseException {
        int id = Integer.parseInt(o.getString("event_id"));
        Date date = fmt.parse(o.getString("event_date"));
        String title = o.getString("title");
        String desc = o.getString("description");
        boolean active = o.getString("active") == "1";
        int type_id = Integer.parseInt(o.getString("type_id"));
        int urgency_id = Integer.parseInt(o.getString("urgency"));

        return new Event(id, date, title, desc);

    }

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

    public int getId() {
        return this.id;
    }

    public Date getDate() {
        return this.date;
    }

    public String getAddress() {
        return this.address;
    }

    public String getTitle() {
        return this.title;
    }

    public boolean isActive() {
        return this.active;
    }

    public String getDescription() {
        return this.description;
    }

    public EventType getType() {
        return this.type;
    }

    public int getUrgency() {
        return this.urgency;
    }

    public Double getLat(){return lat;}

    public Double getLng(){return lng;}

}
