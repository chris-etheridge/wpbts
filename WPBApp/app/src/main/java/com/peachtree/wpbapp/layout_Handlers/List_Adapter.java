package com.peachtree.wpbapp.layout_Handlers;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.entities.*;


import java.text.SimpleDateFormat;
import java.util.ArrayList;

/**
 * Created by Tyron on 8/25/2016.
 */
public class List_Adapter extends BaseAdapter
{

	public enum Type{
		Event,
		Clinic
	}
	private ArrayList list;
	private Context context;
	private Type type;


	public List_Adapter (ArrayList list, Context ctx, Type type){
		this.list = list;
		this.type = type;
		context=ctx;
	}

	@Override
	public int getCount()
	{
		return list.size();
	}

	@Override
	public Object getItem(int i)
	{
		return list.get(i);
	}

	@Override
	public long getItemId(int i)
	{
		long id = -1;

		if(type==Type.Event){
			id = ((Event) list.get(i)).getId();
		}else if(type==Type.Clinic){
			id = ((Clinic) list.get(i)).getId();
		}

		return id;
	}

	public View getView(int pos, View convertView, ViewGroup parent){
		if(convertView == null){
			LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			if(type==Type.Event) {
				convertView = inflater.inflate(R.layout.tile_w_image, parent, false);
			}else if (type==Type.Clinic){
				convertView=inflater.inflate(R.layout.tile_1line, parent, false);
			}
		}

		if(type== Type.Event) {
			TextView name = (TextView) convertView.findViewById(R.id.TXT_name);
			TextView date = (TextView) convertView.findViewById(R.id.TXT_date);
			Event event = (Event)list.get(pos);

			name.setText(event.getTitle());
			date.setText(new SimpleDateFormat("dd-MM-yyyy").format(event.getDate()));


		}else if(type==Type.Clinic){
			TextView name = (TextView) convertView.findViewById(R.id.TXT_name);
			Event event = (Event)list.get(pos);

			name.setText(event.getTitle());
		}
		return convertView;
	}
}
