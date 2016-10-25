package com.peachtree.wpbapp.activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import java.util.Date;
import java.util.ArrayList;

public class Event_List_Fragment extends DialogFragment{

	private Activity parent;
	private int stackNum;

	public static Event_List_Fragment init(int stackNum){
		Event_List_Fragment fragment = new Event_List_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");
	}

	private ArrayList getListData(){
		ArrayList<Event> results = new ArrayList<>();
		Event event = new Event(0,new Date(16,12,1),"Event1");
		results.add(event);
		event = new Event(1,new Date(16,12,2),"Event2");
		results.add(event);
		return results;
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		View view = inflater.inflate(R.layout.event_list_layout, container, false);

		ArrayList events=getListData();
		ListView list = (ListView)view.findViewById(R.id.event_list);
		list.setAdapter(new List_Adapter(events, parent, List_Adapter.Type.Event));

		return view;
	}
}
