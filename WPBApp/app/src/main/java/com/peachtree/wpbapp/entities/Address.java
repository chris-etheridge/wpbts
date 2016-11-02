package com.peachtree.wpbapp.Entities;

public class Address {

	private int id;
	private String city;
	private String office;
	private String street;
	private String area;
	private String area_code;
	private int number;

	public Address(String city, String office, String street, String area, String code, int number) {
		this.city = city;
		this.office = office;
		this.street = street;
		this.area = area;
		this.area_code = code;
		this.number = number;
	}

	public int getId()
	{
		return id;
	}

	public String getCity()
	{
		return city;
	}

	public String getOffice()
	{
		return office;
	}

	public String getStreet()
	{
		return street;
	}

	public String getArea()
	{
		return area;
	}

	public String getArea_code()
	{
		return area_code;
	}

	public int getNumber()
	{
		return number;
	}
}
