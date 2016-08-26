package com.peachtree.wpbapp.entities;

import java.net.URL;

/**
 * Created by tyron_000 on 8/26/2016.
 */
public class Clinic {

	private int id;
	private Address address;
	private String contact1;
	private String contact2;
	private String description;
	private URL img_url;

	public Clinic(){}

	public Clinic(int id, Address address ){
		this.id=id;
		this.address=address;
	}

	public int getId() {
		return this.id;
	}


	public Address getAddress() {
		return this.address;
	}

	public String getDescription() {
		return this.description;
	}

	public String getContact1(){return this.contact1;}

	public String getContact2(){return this.contact2;}

	public URL getImg_url(){return this.img_url;}
}
