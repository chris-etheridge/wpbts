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
import java.net.URL;
import java.text.ParseException;
import java.util.ArrayList;

/**
* Clinic entity class
*/
public class Clinic {

	private int id;

	private String name;
	private String address;
	private String contact1;
	private String contact2;
	private String description;

	private URL img_url;

	private Bitmap image;

	private double lat, lng;

	public Clinic(int id, String name, String description, double lat, double lng) {
		this.id = id;
		this.description = description;
		this.name = name;

		this.lat = lat;
		this.lng = lng;
	}

	public static ArrayList<Clinic> ClinicsFromJsonArray(JSONArray a) throws JSONException, ParseException {
		ArrayList<Clinic> cs = new ArrayList<>();

		for(int i = 0; i < a.length(); i++) {
			cs.add(ClinicFromJsonObject(a.getJSONObject(i)));
		}

		return cs;
	}

	public static Clinic ClinicFromJsonObject(JSONObject o) throws JSONException, ParseException {
		int id = Integer.parseInt(o.getString("clinic_id"));
		String desc = o.getString("description");
		String name = "Clinic";

		double lat = o.getDouble("latitude");
		double lng = o.getDouble("longitude");

		return new Clinic(id, desc, name, lat, lng);
	}

	public void loadImage(String baseUrl, ImageView view, ProgressBar loaderView) {
		// start our task
		new DownloadImageTask(view, loaderView).execute(baseUrl + "/img/events/" + id + ".jpg");
	}

	// generic task to download an image
	private class DownloadImageTask extends AsyncTask<String, Void, Bitmap> {
		ImageView view;
		ProgressBar loaderView;

		public DownloadImageTask(ImageView bmImage, ProgressBar loaderView) {
			view = bmImage;
			this.loaderView = loaderView;
			// hide our image view & show loader
			view.setVisibility(View.INVISIBLE);
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
			loaderView.setVisibility(View.GONE);
		}
	}

	// - Getters and setters -
	public int getId() {
		return this.id;
	}

	public String getAddress() {

		return this.address;
	}

	public String getDescription() {
		return this.description;
	}

	public String getContact1(){return this.contact1;}

	public String getContact2(){return this.contact2;}

	public URL getImg_url(){return this.img_url;}

	public String getName(){
		return name;
	}

	public double getLat(){
		return lat;
	}

	public double getLng(){
		return lng;
	}

}
