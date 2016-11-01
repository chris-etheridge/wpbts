package com.peachtree.wpbapp.layout_Handlers;

import android.app.Activity;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Activity.Clinic_Info_Fragment;
import com.peachtree.wpbapp.Activity.Event_Info_Fragment;
import com.peachtree.wpbapp.Entities.*;

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

	public View getView(int pos, View convertView, final ViewGroup parent){
		if(convertView == null){
			LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			convertView = inflater.inflate(R.layout.tile_w_image, parent, false);
		}

		if(type== Type.Event) {
			TextView name = (TextView) convertView.findViewById(R.id.TXT_name);
			TextView date = (TextView) convertView.findViewById(R.id.TXT_date);
			final Event event = (Event)list.get(pos);

			name.setText(event.getTitle());
			date.setText(new SimpleDateFormat("dd-MM-yyyy").format(event.getDate()));
			convertView.setOnClickListener(new View.OnClickListener()
			{
				@Override
				public void onClick(View view)
				{
					FragmentManager manager = ((Activity)context).getFragmentManager();
					FragmentTransaction transaction = manager.beginTransaction();
					transaction.setCustomAnimations(android.support.design.R.anim.abc_popup_enter, android.support.design.R.anim.abc_popup_exit);
					Event_Info_Fragment event_dialog = Event_Info_Fragment.init(event.getId());
					event_dialog.show(transaction, "event_dialog");
				}
			});


		}else if(type==Type.Clinic){
			TextView name = (TextView) convertView.findViewById(R.id.TXT_name);
			TextView date = (TextView) convertView.findViewById(R.id.TXT_date);
			Clinic clinic = (Clinic)list.get(pos);

			name.setText(clinic.getName());
			date.setVisibility(View.GONE);
			convertView.setOnClickListener(new View.OnClickListener()
			{
				@Override
				public void onClick(View view)
				{
					FragmentManager manager = ((Activity)context).getFragmentManager();
					FragmentTransaction transaction = manager.beginTransaction();
					Clinic_Info_Fragment clinic_dialog = Clinic_Info_Fragment.init(1);
					clinic_dialog.show(transaction, "clinic_dialog");
				}
			});
		}
		return convertView;
	}
}
