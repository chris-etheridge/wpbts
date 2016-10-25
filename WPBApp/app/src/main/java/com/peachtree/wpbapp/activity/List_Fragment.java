package com.peachtree.wpbapp.activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.entities.Clinic;
import com.peachtree.wpbapp.entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import java.util.ArrayList;

public class List_Fragment extends DialogFragment{

	private Activity parent;
	private int stackNum, type;
	public static final int CLINIC = 1, EVENT = 2;

	public static List_Fragment init(int stackNum, int type){
		List_Fragment fragment = new List_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		args.putInt("type", type);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");
		type = getArguments().getInt("type");
	}

	private ArrayList getListData(){
		ArrayList results;
		switch(type){
			case CLINIC:
				ArrayList<Clinic> clinics = new ArrayList<>(); //TO-DO Replace with DB call.
				results = clinics;
				break;
			case EVENT:
				ArrayList<Event> events = new ArrayList<>();  //TO-DO Replace with DB call.
				results = events;
				break;
			default:
				results = null;
				break;
		}
		return results;
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		View view = inflater.inflate(R.layout.event_list_layout, container, false);

		ArrayList data=getListData();
		if(data != null)
		{
			ListView list = (ListView) view.findViewById(R.id.list);
			switch (type)
			{
				case CLINIC:
					list.setAdapter(new List_Adapter(data, parent, List_Adapter.Type.Clinic));
					break;
				case EVENT:
					list.setAdapter(new List_Adapter(data, parent, List_Adapter.Type.Event));
					break;
			}
		}

		return view;
	}
}
