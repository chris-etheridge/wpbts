package com.peachtree.wpbapp.Entities;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.net.URL;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;

/**
 * Created by tyron_000 on 8/26/2016.
 */
public class Clinic {

	private int id;
	private String name;
	private String address;
	private String contact1;
	private String contact2;
	private String description;
	private URL img_url;
	private double lat, lng;

	public Clinic() {}


	public Clinic(String name, String description) {
		this.description = description;
		this.name = name;
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

		return new Clinic(desc, name);
	}

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
