package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.FragmentTransaction;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Clinic;

import java.util.ArrayList;
import java.util.Locale;

public class Clinic_Info_Fragment extends DialogFragment implements OnMapReadyCallback
{

	private Activity parent;
	private int id, array_index;
	private ArrayList<Clinic> clinics;
	private Clinic clinic;
	private float mCurrenty;
	private GoogleMap mMap;
	private MapFragment mapFragment;

	public static Clinic_Info_Fragment init(int id){
		Clinic_Info_Fragment fragment = new Clinic_Info_Fragment();

		Bundle args = new Bundle();
		args.putInt("id", id);
		fragment.setArguments(args);

		return fragment;
	}

	@Override
	public void onMapReady(GoogleMap googleMap) {
		mMap = googleMap;
		if(clinic != null){
			LatLng co_ord = new LatLng(clinic.getLat(), clinic.getLng());
			mMap.addMarker(new MarkerOptions().title(clinic.getName()).position(co_ord).draggable(false));
			mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(co_ord, 10));
		}else{
			Toast.makeText(parent, "Clinic Location could not be found", Toast.LENGTH_SHORT).show();
		}
	}

	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
		parent = getActivity();
		id = getArguments().getInt("id");

		if(clinics != null){
			int i = 0;
			while(i< clinics.size() && clinic == null){
				if(clinics.get(i).getId() == id){
					clinic = clinics.get(i);
					array_index = i;
				}
			}
		}

		mapFragment = new MapFragment();
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.clinic_info_layout, container, false);

		FragmentTransaction transaction = getChildFragmentManager().beginTransaction();
		transaction.add(R.id.map_layout, mapFragment, "map").commit();
		mapFragment.getMapAsync(this);



		mCurrenty = view.getY();
		final float originalY = mCurrenty;


		if(clinic != null){

			TextView title = (TextView)view.findViewById(R.id.clinic_title);
			TextView details = (TextView)view.findViewById(R.id.TXT_details);
			Button get_directions = ((Button)view.findViewById(R.id.BTN_directions));

			title.setText(clinic.getName());
			details.setText(generateDetails());
			get_directions.setOnClickListener(new View.OnClickListener() {
				@Override
				public void onClick(View v) {
					String uri = String.format(Locale.ENGLISH, "geo:%f,%f", clinic.getLat(), clinic.getLng());
					Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(uri));
					parent.startActivity(intent);
				}
			});

		}else{
			Toast.makeText(getActivity(), "Could Not Load Clinic.", Toast.LENGTH_SHORT);

			dismiss();
		}

		view.findViewById(R.id.pull_grip).setOnTouchListener(new View.OnTouchListener()
		{
			private float offset;
			private int threshold = (int)(getDialog().getWindow().getWindowManager().getDefaultDisplay().getHeight() * 2/3.0);

			@Override
			public boolean onTouch(View v, MotionEvent event)
			{
				int action = event.getAction();
				if(action == MotionEvent.ACTION_DOWN){
					offset= mCurrenty - event.getRawY();
				}else if(action == MotionEvent.ACTION_MOVE){
					mCurrenty = (int)(event.getRawY() + offset);
					if(mCurrenty > originalY)
					{
						view.setY(mCurrenty);
					}
				}else if(action == MotionEvent.ACTION_UP){

					if(mCurrenty > originalY + threshold){
						dismiss();
					}else{
						mCurrenty = originalY;
						view.setY(mCurrenty);
					}
				}
				return true;
			}
		});

		return view;
	}

	@Override
	public void onStart(){
		super.onStart();
		WindowManager wm = (WindowManager)parent.getSystemService(Context.WINDOW_SERVICE);
		Display display = wm.getDefaultDisplay();
		getDialog().getWindow().setBackgroundDrawable(null);
		getDialog().getWindow().setLayout(display.getWidth() - 50, display.getHeight() - 50);
	}

	public void loadClinics(ArrayList<Clinic> c){
		clinics = c;
	}

	private String generateDetails(){
		String output;

		output = String.format("Contact 1: %s\nContact 2%s\n\n%s", clinic.getContact1(), clinic.getContact2(), clinic.getDescription());

		return output;
	}
}
