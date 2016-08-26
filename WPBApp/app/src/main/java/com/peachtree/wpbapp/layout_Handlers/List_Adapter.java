package com.peachtree.wpbapp.layout_Handlers;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.entities.Event;


import java.text.SimpleDateFormat;
import java.util.ArrayList;

/**
 * Created by Tyron on 8/25/2016.
 */
public class List_Adapter extends BaseAdapter
{

	private ArrayList<Event> eventList;
	private Context context;

	public List_Adapter (ArrayList<Event> eventList, Context ctx){
		this.eventList=eventList;
		context=ctx;
	}

	@Override
	public int getCount()
	{
		return eventList.size();
	}

	@Override
	public Object getItem(int i)
	{
		return eventList.get(i);
	}

	@Override
	public long getItemId(int i)
	{
		return eventList.get(i).getId();
	}

	public View getView(int pos, View convertView, ViewGroup parent){
		if(convertView == null){
			LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			convertView = inflater.inflate(R.layout.tile_w_image,parent,false);
		}
		TextView name=(TextView)convertView.findViewById(R.id.TXT_name);
		TextView date=(TextView)convertView.findViewById(R.id.TXT_date);
		Event event = eventList.get(pos);

		name.setText(event.getTitle());
		date.setText(new SimpleDateFormat("dd-MM-yyyy").format(event.getDate()));

		return convertView;
	}
}
